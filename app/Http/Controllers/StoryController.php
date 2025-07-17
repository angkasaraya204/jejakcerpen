<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use App\Models\Views;
use App\Models\Follow;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoryController extends Controller
{
    private function getTrendingStories($period = 'all', $limit = 5)
    {
        $query = Story::with(['user', 'category'])
            ->withCount(['votes as upvotes_count' => function($query) {
                $query->where('vote_type', 'upvote');
            }]);

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
        }

        // Urutkan berdasarkan jumlah upvote terbanyak, lalu berdasarkan yang terbaru.
        // Ambil data sesuai limit. Semua proses ini dilakukan di database.
        return $query->orderByDesc('upvotes_count')
                     ->orderByDesc('created_at')
                     ->take($limit)
                     ->get();
    }

    private function getPopularStories($period = 'all', $limit = 8)
    {
        $query = Story::with(['user', 'category'])
                      ->withCount('views');

        switch ($period) {
            case 'daily':
                $query->where('created_at', '>=', now()->subDay());
                break;
            case 'weekly':
                $query->where('created_at', '>=', now()->subWeek());
                break;
        }

        // Urutkan berdasarkan jumlah views terbanyak dan ambil sesuai limit.
        return $query->orderByDesc('views_count')
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

    private function getPopularCategoriesByViews($limit = 5)
    {
        return Category::query()
            ->select('categories.id', 'categories.name', 'categories.slug')
            ->selectRaw('COUNT(stories_views.id) as total_views')
            ->join('stories', 'categories.id', '=', 'stories.category_id')
            ->join('stories_views', 'stories.id', '=', 'stories_views.story_id')
            ->groupBy('categories.id', 'categories.name', 'categories.slug')
            ->orderByDesc('total_views')
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
        $query = Story::with(['user', 'category', 'userVote', 'votes'])->withCount('views');

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

        $popularCategoriesByViews = $this->getPopularCategoriesByViews(5);

        return view('home.index', compact(
            'stories',
            'allCategories',
            'trendingStories',
            'popularStoriesAllTime',
            'popularStoriesDaily',
            'popularStoriesWeekly',
            'popularAuthors',
            'isFollowing',
            'popularCategoriesByViews'
        ));
    }

    public function show(Story $story)
    {
       if (Auth::check()) {
            // LOGIKA UNTUK PENGGUNA YANG LOGIN
            // Mencari view berdasarkan story_id dan user_id.
            // Jika belum ada, akan dibuat. Jika sudah ada, tidak terjadi apa-apa.
            Views::updateOrCreate(
                ['story_id' => $story->id, 'user_id' => Auth::id()]
            );
        } else {
            // LOGIKA UNTUK PENGUNJUNG/GUEST
            // 1. Ambil daftar cerita yang sudah dilihat dari session
            $viewedStories = Session::get('viewed_stories', []);

            // 2. Cek apakah ID cerita ini belum ada di dalam daftar session
            if (!in_array($story->id, $viewedStories)) {
                // 3. Jika belum ada, catat kunjungan di database
                Views::create([
                    'story_id' => $story->id,
                    'user_id' => null // user_id dikosongkan untuk guest
                ]);

                // 4. Tambahkan ID cerita ini ke dalam session agar tidak dihitung lagi
                Session::push('viewed_stories', $story->id);
            }
        }

        // Memuat data relasi untuk ditampilkan (tidak ada perubahan di sini)
        $story->load(['user', 'category', 'comments' => function($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }]);

        // Mengembalikan view 'home.detail'
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
