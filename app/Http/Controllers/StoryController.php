<?php

namespace App\Http\Controllers;

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
            ->where('status', 'approved')
            ->withCount(['votes' => function($query) {
                $query->where('vote_type', 'like');
            }])
            ->withCount('comments')
            ->orderByDesc('votes_count')
            ->orderByDesc('comments_count')
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();
    }

    private function getPopularCategories($limit = 5)
    {
        return Category::withCount(['stories' => function($query) {
            $query->where('status', 'approved');
        }])
        ->orderByDesc('stories_count')
        ->take($limit)
        ->get();
    }

    private function getPopularAuthors($limit = 5)
    {
        return \App\Models\User::withCount(['stories' => function($query) {
            $query->where('status', 'approved');
        }])
        ->withCount(['votes' => function($query) {
            $query->where('vote_type', 'like');
        }])
        ->having('stories_count', '>', 0)
        ->orderByDesc('votes_count')
        ->orderByDesc('stories_count')
        ->take($limit)
        ->get();
    }

    public function index(Request $request)
    {
        $query = Story::with(['user', 'category'])->where('status', 'approved');

        $stories = $query->where('user_id', Auth::id())->latest('published_at')->paginate(10);
        $categories = Category::all();

        return view('cerita.index', compact('stories'));
    }

    public function home(Request $request)
    {
        $query = Story::with(['user', 'category'])->where('status', 'approved');

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $isFollowing = [];

        // Jika user login, cek status following untuk semua penulis cerita
        if (Auth::check()) {
            $stories = $query->latest('published_at')->get();
            foreach ($stories as $story) {
                if ($story->user_id) {
                    $isFollowing[$story->user_id] = Follow::where('follower_id', Auth::id())
                        ->where('followed_id', $story->user_id)
                        ->exists();
                }
            }
        }

        $stories = $query->latest('published_at')->paginate(10);
        $categories = Category::all();

        // Get trending stories, popular categories, and popular authors
        $trendingStories = $this->getTrendingStories();
        $popularCategories = $this->getPopularCategories();
        $popularAuthors = $this->getPopularAuthors();

        $isFollowing = $isFollowing ?? false;

        return view('cerita.home.index', compact(
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
        if ($story->status !== 'approved' && (Auth::guest() || !Auth::user()->hasRole('admin'))) {
            abort(404);
        }

        $story->load(['user', 'category', 'comments' => function($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }]);

        return view('cerita.home.detail', compact('story'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('cerita.create', compact('categories'));
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
        $story->status = 'pending';
        $story->user_id = Auth::id();
        $story->save();

        return back()->with('success', 'Cerita telah dikirim dan menunggu persetujuan.');
    }

    public function edit(Story $story)
    {
        $categories = Category::all();
        return view('cerita.edit', compact('story', 'categories'));
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

        return back()->with('success', 'Cerita telah diperbarui.');
    }

    public function moderate()
    {
        $pendingStories = Story::with(['user', 'category'])->where('status', 'pending')->latest()->paginate(10);
        return view('moderasi.index', compact('pendingStories'));
    }

    public function approve(Story $story)
    {
        $story->status = 'approved';
        $story->published_at = now();
        $story->save();

        return redirect()->route('stories.moderate')->with('success', 'Cerita berhasil disetujui dan dipublikasikan.');
    }

    public function reject(Story $story)
    {
        $story->status = 'rejected';
        $story->save();

        return redirect()->route('stories.moderate')->with('success', 'Cerita ditolak.');
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
