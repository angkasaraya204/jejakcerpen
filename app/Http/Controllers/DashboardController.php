<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Story;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $totalStories = Story::count();

            $totalComments = Comment::count();

            // Stats for chart - last 7 days activity
            $dateStart = Carbon::now()->subDays(6)->startOfDay();
            $dates = [];
            $storyCounts = [];
            $commentCounts = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $dateStart->copy()->addDays($i);
                $dates[] = $date->format('Y-m-d');

                $storyCounts[] = Story::whereDate('created_at', $date->format('Y-m-d'))->count();
                $commentCounts[] = Comment::whereDate('created_at', $date->format('Y-m-d'))->count();
            }
        } elseif (Auth::user()->hasRole('user')) {
            $totalStories = Story::where('user_id', Auth::id())->count();
            $totalComments = Comment::where('user_id', Auth::id())->count();

            // Stats for chart - last 7 days activity
            $dateStart = Carbon::now()->subDays(6)->startOfDay();
            $dates = [];
            $storyCounts = [];
            $commentCounts = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $dateStart->copy()->addDays($i);
                $dates[] = $date->format('Y-m-d');

                $storyCounts[] = Story::where('user_id', Auth::id())->whereDate('created_at', $date->format('Y-m-d'))->count();
                $commentCounts[] = Comment::where('user_id', Auth::id())->whereDate('created_at', $date->format('Y-m-d'))->count();
            }
        }

        $pendingStories = Story::where('status', 'pending')->count();
        $approvedStories = Story::where('status', 'approved')->count();
        $rejectedStories = Story::where('status', 'rejected')->count();
        $totalUsers = User::count();

        // Category distribution
        $categoryStats = DB::table('stories')
            ->join('categories', 'stories.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->get();

        return view('dashboard', compact(
            'totalStories',
            'pendingStories',
            'approvedStories',
            'rejectedStories',
            'totalUsers',
            'totalComments',
            'dates',
            'storyCounts',
            'commentCounts',
            'categoryStats'
        ));
    }
}
