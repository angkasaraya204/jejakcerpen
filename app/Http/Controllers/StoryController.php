<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use App\Models\Follow;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    private function getTrendingStories($limit = 5)
    {
        return Story::with(['user', 'category'])
            ->withCount(['votes' => function($query) {
                $query->where('vote_type', 'upvote');
            }])
            ->withCount('comments')
            ->orderByDesc('votes_count')
            ->orderByDesc('comments_count')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }

    private function getPopularCategories($limit = 5)
    {
        return Category::withCount('stories')
        ->orderByDesc('stories_count')
        ->take($limit)
        ->get();
    }

    private function getPopularAuthors($limit = 5)
    {
        return User::withCount('stories')
        ->withCount(['votes' => function($query) {
            $query->where('vote_type', 'upvote');
        }])
        ->having('stories_count', '>', 0)
        ->orderByDesc('votes_count')
        ->orderByDesc('stories_count')
        ->take($limit)
        ->get();
    }

    public function index(Request $request)
    {


        if (Auth::user()->hasRole('user')) {
            $query = Story::with(['user', 'category']);

            $stories = $query->where('user_id', Auth::id())->latest('created_at')->paginate(10);
            $categories = Category::all();
        } elseif (Auth::user()->hasRole(['moderator', 'admin'])) {
            $query = Story::with(['user', 'category']);

            $stories = $query->latest('created_at')->paginate(10);
            $categories = Category::all();
        }

        return view('moderasi.cerita.index', compact('stories'));
    }

    public function home(Request $request)
    {
        $query = Story::with(['user', 'category']);

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $isFollowing = [];

        // Jika user login, cek status following untuk semua penulis cerita
        if (Auth::check()) {
            $stories = $query->latest('created_at')->get();
            foreach ($stories as $story) {
                if ($story->user_id) {
                    $isFollowing[$story->user_id] = Follow::where('follower_id', Auth::id())
                        ->where('followed_id', $story->user_id)
                        ->exists();
                }
            }
        }

        $stories = $query->latest('created_at')->paginate(10);
        $categories = Category::all();

        // Get trending stories, popular categories, and popular authors
        $trendingStories = $this->getTrendingStories();
        $popularCategories = $this->getPopularCategories();
        $popularAuthors = $this->getPopularAuthors();

        $isFollowing = $isFollowing ?? false;

        return view('home.index', compact(
            'stories',
            'categories',
            'trendingStories',
            'popularCategories',
            'popularAuthors',
            'isFollowing'
        ));
    }

    public function show(Story $story)
    {
        $story->load(['user', 'category', 'comments' => function($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }]);

        return view('home.detail', compact('story'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('moderasi.cerita.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'anonymous' => 'boolean',
        ]);

        $story = new Story($validated);
        $story->user_id = Auth::id();
        $story->save();

        return back()->route('stories.index')->with('success', 'Cerita telah dikirim dan menunggu persetujuan.');
    }

    public function edit(Story $story)
    {
        $categories = Category::all();
        return view('moderasi.cerita.edit', compact('story', 'categories'));
    }

    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'anonymous' => 'boolean',
        ]);

        $story->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'anonymous' => $validated['anonymous'] ?? false,
        ]);

        return back()->route('stories.index')->with('success', 'Cerita telah diperbarui.');
    }

    public function markSensitive(Story $story)
    {
        $story->is_sensitive = !$story->is_sensitive;
        $story->save();

        $status = $story->is_sensitive ? 'ditandai sebagai sensitif' : 'ditandai sebagai tidak sensitif';
        return back()->with('success', "Cerita berhasil $status.");
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return redirect()->route('stories.index')->with('success', 'Cerita berhasil dihapus.');
    }
}
