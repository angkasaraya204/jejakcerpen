<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use App\Models\Follow;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    private function getTrendingStories($period = 'all', $limit = 5)
    {
        $query = Story::with(['user', 'category']);

        // Filter berdasarkan periode
        switch ($period) {
            case 'daily':
                $query->where('created_at', '>=', now()->subDay());
                break;
            case 'weekly':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'monthly':
                $query->where('created_at', '>=', now()->subMonth());
                break;
            case 'all':
            default:
                // Tidak ada filter waktu
                break;
        }

        // Ambil semua stories dengan count, lalu filter dan sort di PHP
        $stories = $query->withCount([
                'votes as upvotes_count' => function($query) {
                    $query->where('vote_type', 'upvote');
                },
                'votes as downvotes_count' => function($query) {
                    $query->where('vote_type', 'downvote');
                },
                'comments as comments_count'
            ])
            ->get();

        // Filter dan sort di collection
        $trendingStories = $stories
            ->filter(function($story) {
                return $story->upvotes_count > 0; // Minimal 1 upvote
            })
            ->map(function($story) {
                // Hitung trending score
                $story->trending_score = $story->upvotes_count - $story->downvotes_count + ($story->comments_count * 0.5);
                return $story;
            })
            ->filter(function($story) {
                return $story->trending_score > 0; // Trending score harus positif
            })
            ->sortByDesc('trending_score')
            ->sortByDesc('created_at') // Secondary sort untuk score yang sama
            ->take($limit)
            ->values(); // Reset keys

        return $trendingStories;
    }

    // Method untuk popular stories tanpa pagination
    private function getPopularStories($period = 'all', $limit = 8)
    {
        $query = Story::with(['user', 'category']);

        switch ($period) {
            case 'daily':
                $query->where('created_at', '>=', now()->subDay());
                break;
            case 'weekly':
                $query->where('created_at', '>=', now()->subWeek());
                break;
        }

        return $query->withCount([
                'votes as upvotes_count' => function($query) {
                    $query->where('vote_type', 'upvote');
                },
                'votes as downvotes_count' => function($query) {
                    $query->where('vote_type', 'downvote');
                },
                'comments as comments_count'
            ])
            ->get()
            ->map(function ($story) {
                $story->popularity_score =
                    ($story->upvotes_count * 3) +
                    ($story->comments_count * 2) -
                    ($story->downvotes_count * 1);
                return $story;
            })
            ->sortByDesc('popularity_score')
            ->take($limit);
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

    public function index(Request $request, Report $report)
    {
        if (Auth::user()->hasRole('user')) {
            $query = Story::with(['user', 'category']);

            $stories = $query->where('user_id', Auth::id())->latest('created_at')->paginate(10);
            $categories = Category::all();
            return view('moderasi.cerita.index', compact('stories'));
        } elseif (Auth::user()->hasRole('admin')) {
            $query = Story::with(['user', 'category']);

            $stories = $query->latest('created_at')->paginate(10);
            $categories = Category::all();

            return view('moderasi.cerita.index', compact('stories'));
        }
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
        $allCategories = Category::withCount('stories')
        ->orderByDesc('stories_count')
        ->get();

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

        $stories = $query->latest('created_at')->paginate(6);

        // Cerita populer tanpa pagination
        $popularStoriesAllTime = $this->getPopularStories('all', 8);
        $popularStoriesDaily = $this->getPopularStories('daily', 8);
        $popularStoriesWeekly = $this->getPopularStories('weekly', 8);

        $trendingStories = $this->getTrendingStories();
        $popularAuthors = $this->getPopularAuthors();

        return view('home.index', compact(
            'stories',
            'allCategories',
            'trendingStories',
            'popularStoriesAllTime',
            'popularStoriesDaily',
            'popularStoriesWeekly',
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

        $story = new Story([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'anonymous' => $validated['anonymous'] ?? false,
        ]);

        $story->user_id = Auth::id();
        $story->save();

        return redirect()->route('stories.index')->with('success', 'Cerita telah dikirim.');
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

        return redirect()->route('stories.index')->with('success', 'Cerita telah diperbarui.');
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return back()->with('success', 'Cerita berhasil dihapus.');
    }
}
