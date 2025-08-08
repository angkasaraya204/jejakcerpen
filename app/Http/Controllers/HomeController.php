<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use App\Models\Story;
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

        $allCategories = Category::withCount(['stories' => function ($query) {
            $query->where('status', 'approved');
        }])->orderByDesc('stories_count')->get();

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

        return $query->having('upvotes_count', '>', 0)
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

        return $query->orderByDesc('views_count')
                     ->take($limit)
                     ->get();
    }

    private function getPopularAuthors($limit = 5)
    {
        $anonymousStoriesCount = Story::where('anonymous', true)
                                    ->where('status', 'approved')
                                    ->count();

        $finalAuthorsList = collect();

        if ($anonymousStoriesCount > 0) {
            $anonymousAuthor = new \stdClass();
            $anonymousAuthor->name = null;
            $anonymousAuthor->stories_count = $anonymousStoriesCount;

            $finalAuthorsList->push($anonymousAuthor);
        }

        $remainingLimit = $limit - $finalAuthorsList->count();

        if ($remainingLimit > 0) {
            $realAuthors = User::select('users.id', 'users.name')
                ->withCount(['stories' => function ($query) {
                    $query->where('anonymous', false)->where('status', 'approved');
                }])
                ->having('stories_count', '>', 0)
                ->orderByDesc('stories_count')
                ->take($remainingLimit)
                ->get();

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
