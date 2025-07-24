<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use App\Models\Story;
use App\Models\Follow;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Story::with(['user', 'category', 'userVote', 'votes'])->withCount('views')->where('status', 'approved');

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $isFollowing = [];
        $allCategories = Category::withCount(['stories' => function ($query) {
            $query->where('status', 'approved');
        }])->orderByDesc('stories_count')->get();

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

        $stories = $query->latest('created_at')->paginate(5);

        $popularStoriesAllTime = $this->getPopularStories('all', 5);
        $popularStoriesDaily = $this->getPopularStories('daily', 5);
        $popularStoriesWeekly = $this->getPopularStories('weekly', 5);

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

    private function getTrendingStories($period = 'all', $limit = 5)
    {
        $query = Story::with(['user', 'category'])
            ->withCount(['votes as upvotes_count' => function($query) {
                $query->where('vote_type', 'upvote');
            }]);

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
        return $query->having('upvotes_count', '>', 0) // <-- Tambahkan baris ini
                 ->orderByDesc('upvotes_count')
                 ->orderByDesc('created_at')
                 ->take($limit)
                 ->get();
    }

    private function getPopularStories($period = 'all', $limit = 5)
    {
        $query = Story::with(['user', 'category'])
                      ->withCount('views')->where('status', 'approved');

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
        // --- Langkah 1: Siapkan data untuk grup "Anonim" ---
        $anonymousStoriesCount = Story::where('anonymous', true)
                                    ->where('status', 'approved')
                                    ->count();

        // Mulai dengan koleksi (daftar) kosong
        $finalAuthorsList = collect();

        // Jika ada cerita anonim, masukkan "Anonim" sebagai item pertama
        if ($anonymousStoriesCount > 0) {
            $anonymousAuthor = new \stdClass();
            $anonymousAuthor->name = null; // Akan menjadi 'Anonim' di Blade
            $anonymousAuthor->stories_count = $anonymousStoriesCount;

            $finalAuthorsList->push($anonymousAuthor);
        }

        // --- Langkah 2: Ambil penulis dengan nama asli yang populer ---

        // Hitung sisa slot yang tersedia dalam daftar
        $remainingLimit = $limit - $finalAuthorsList->count();

        // Hanya jalankan kueri ini jika masih ada sisa slot
        if ($remainingLimit > 0) {
            $realAuthors = User::select('users.id', 'users.name')
                // Hitung hanya cerita yang tidak anonim dan sudah disetujui
                ->withCount(['stories' => function ($query) {
                    $query->where('anonymous', false)->where('status', 'approved');
                }])
                // Hanya ambil user yang punya cerita (tidak anonim)
                ->having('stories_count', '>', 0)
                ->orderByDesc('stories_count')
                ->take($remainingLimit) // Ambil sisanya untuk memenuhi limit 5
                ->get();

            // --- Langkah 3: Gabungkan daftar "Anonim" dengan daftar penulis asli ---
            $finalAuthorsList = $finalAuthorsList->merge($realAuthors);
        }

        return $finalAuthorsList;
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
}
