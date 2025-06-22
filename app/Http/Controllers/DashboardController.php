<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vote;
use App\Models\Story;
use App\Models\Follow;
use App\Models\Report;
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
            $totalUsers = User::count();

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

            // Category distribution
            $categoryStats = DB::table('stories')
                ->join('categories', 'stories.category_id', '=', 'categories.id')
                ->select('categories.name', DB::raw('count(*) as total'))
                ->groupBy('categories.name')
                ->get();

            // NEW: Anonymous vs. Non-Anonymous Posts distribution
            $anonymousStories = Story::where('anonymous', true)->count();
            $nonAnonymousStories = Story::where('anonymous', false)->count();
            $anonymousData = [$anonymousStories, $nonAnonymousStories];

            // NEW: User interaction trend (30 days)
            $interactionStart = Carbon::now()->subDays(29)->startOfDay();
            $interactionDates = [];
            $storyTrend = [];
            $commentTrend = [];
            $voteTrend = [];

            for ($i = 0; $i < 30; $i++) {
                $date = $interactionStart->copy()->addDays($i);
                $interactionDates[] = $date->format('d/m');

                $storyTrend[] = Story::whereDate('created_at', $date->format('Y-m-d'))->count();
                $commentTrend[] = Comment::whereDate('created_at', $date->format('Y-m-d'))->count();
                $voteTrend[] = Vote::whereDate('created_at', $date->format('Y-m-d'))->count();
            }

            // NEW: Anonymous feature usage trend (6 months)
            $monthStart = Carbon::now()->subMonths(5)->startOfMonth();
            $monthLabels = [];
            $anonymousStoryMonthly = [];
            $anonymousCommentMonthly = [];

            for ($i = 0; $i < 6; $i++) {
                $month = $monthStart->copy()->addMonths($i);
                $monthLabels[] = $month->format('M Y');

                // Get anonymous stories for this month
                $anonymousStoryMonthly[] = Story::where('anonymous', true)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();

                // Get anonymous comments for this month
                $anonymousCommentMonthly[] = Comment::where('anonymous', true)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }

            // NEW: User growth chart (12 months)
            $growthStart = Carbon::now()->subMonths(11)->startOfMonth();
            $growthMonths = [];
            $newUserCounts = [];
            $activeUserCounts = [];

            for ($i = 0; $i < 12; $i++) {
                $month = $growthStart->copy()->addMonths($i);
                $growthMonths[] = $month->format('M Y');

                // New users registered this month
                $newUserCounts[] = User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();

                // Active users this month (users who created content)
                $activeThisMonth = DB::table(DB::raw("
                    (SELECT DISTINCT user_id FROM stories
                    WHERE YEAR(created_at) = {$month->year} AND MONTH(created_at) = {$month->month}
                    UNION
                    SELECT DISTINCT user_id FROM comments
                    WHERE YEAR(created_at) = {$month->year} AND MONTH(created_at) = {$month->month}
                    UNION
                    SELECT DISTINCT user_id FROM votes
                    WHERE YEAR(created_at) = {$month->year} AND MONTH(created_at) = {$month->month}) AS active_users
                "))->count();

                $activeUserCounts[] = $activeThisMonth;
            }
        } elseif (Auth::user()->hasRole('user')) {
            $totalStories = Story::where('user_id', Auth::id())->count();
            $totalComments = Comment::where('user_id', Auth::id())->count();

            // Stats for chart - last 7 days activity
            $dateStart = Carbon::now()->subDays(6)->startOfDay();
            $dates = [];
            $storyCounts = [];
            $commentCounts = [];
            $voteCounts = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $dateStart->copy()->addDays($i);
                $dates[] = $date->format('Y-m-d');

                $storyCounts[] = Story::where('user_id', Auth::id())->whereDate('created_at', $date->format('Y-m-d'))->count();
                $commentCounts[] = Comment::where('user_id', Auth::id())->whereDate('created_at', $date->format('Y-m-d'))->count();
                $voteCounts[] = Vote::where('user_id', Auth::id())->whereDate('created_at', $date->format('Y-m-d'))->count();
            }

            $interactionStart = Carbon::now()->subDays(29)->startOfDay();
            $interactionDates = [];
            $storyTrend = [];
            $voteTrend = [];

            for ($i = 0; $i < 30; $i++) {
                $date = $interactionStart->copy()->addDays($i);
                $interactionDates[] = $date->format('d/m');

                $storyTrend[] = Story::whereDate('created_at', $date->format('Y-m-d'))->count();
                $voteTrend[] = Vote::whereDate('created_at', $date->format('Y-m-d'))->count();
            }

            // Tambahan untuk fitur Follow/Teman
            $followingCount = Follow::where('follower_id', Auth::id())->count();
            $followersCount = Follow::where('followed_id', Auth::id())->count();

            // Data untuk profil dan aktivitas pribadi
            $upvotesReceived = Vote::join('stories', 'votes.story_id', '=', 'stories.id')
                ->where('stories.user_id', Auth::id())
                ->where('votes.vote_type', 'upvote')
                ->count();

            $downvotesReceived = Vote::join('stories', 'votes.story_id', '=', 'stories.id')
                ->where('stories.user_id', Auth::id())
                ->where('votes.vote_type', 'downvote')
                ->count();

            $commentReceived = Comment::join('stories', 'comments.story_id', '=', 'stories.id')
                ->where('stories.user_id', Auth::id())
                ->where('comments.parent_id', null)
                ->count();

            // Data untuk chart aktivitas bulanan
            $monthlyData = [];
            $monthlyLabels = [];

            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthlyLabels[] = $month->format('M Y');

                $monthlyData[] = [
                    'stories' => Story::where('user_id', Auth::id())
                        ->whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count(),
                    'comments' => Comment::where('user_id', Auth::id())
                        ->whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count(),
                    'votes' => Vote::where('user_id', Auth::id())
                        ->whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count()
                ];
            }

            // Mengumpulkan data untuk chart aktivitas
            $storyMonthly = collect($monthlyData)->pluck('stories');
            $commentMonthly = collect($monthlyData)->pluck('comments');
            $voteMonthly = collect($monthlyData)->pluck('votes');
        } elseif (Auth::user()->hasRole('moderator')) {
            // Statistik Laporan Cerita
            $storyReportsPending = Report::where('reportable_type', Story::class)
                ->where('status', 'pending')
                ->count();

            $storyReportsValid = Report::where('reportable_type', Story::class)
                ->where('status', 'valid')
                ->count();

            $storyReportsInvalid = Report::where('reportable_type', Story::class)
                ->where('status', 'tidak-valid')
                ->count();

            // Statistik Laporan Komentar
            $commentReportsPending = Report::where('reportable_type', Comment::class)
                ->where('status', 'pending')
                ->count();

            $commentReportsValid = Report::where('reportable_type', Comment::class)
                ->where('status', 'valid')
                ->count();

            $commentReportsInvalid = Report::where('reportable_type', Comment::class)
                ->where('status', 'tidak-valid')
                ->count();

            // Data untuk grafik laporan harian (30 hari terakhir)
            $reportsPerDay = Report::selectRaw('DATE(created_at) as date, count(*) as total')
                ->where('created_at', '>=', Carbon::now()->subDays(29)->startOfDay())
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        // Set data default untuk user
        $followingCount = $followingCount ?? 0;
        $followersCount = $followersCount ?? 0;
        $upvotesReceived = $upvotesReceived ?? 0;
        $downvotesReceived = $downvotesReceived ?? 0;
        $commentReceived = $commentReceived ?? 0;
        $monthlyLabels = $monthlyLabels ?? [];
        $storyMonthly = $storyMonthly ?? [];
        $commentMonthly = $commentMonthly ?? [];
        $voteMonthly = $voteMonthly ?? [];
        $voteCounts = $voteCounts ?? [];

        // Menyiapkan variabel untuk compact berdasarkan role
        $viewData = [];

        // Tambahkan variabel khusus user jika role-nya user
        if (Auth::user()->hasRole('user')) {
            $viewData = array_merge($viewData, [
                'totalStories',
                'totalComments',
                'storyCounts',
                'commentCounts',
                'dates',
                'voteCounts',
                'followingCount',
                'followersCount',
                'upvotesReceived',
                'downvotesReceived',
                'commentReceived',
                'monthlyLabels',
                'storyMonthly',
                'commentMonthly',
                'interactionDates',
                'voteMonthly',
                'storyTrend',
                'voteTrend',
            ]);
        }

        // Tambahkan variabel khusus moderator jika role-nya moderator
        if (Auth::user()->hasRole('moderator')) {
            $viewData = array_merge($viewData, [
                'storyReportsPending',
                'storyReportsValid',
                'storyReportsInvalid',
                'commentReportsPending',
                'commentReportsValid',
                'commentReportsInvalid',
                'reportsPerDay'
            ]);
        }

        // Tambahkan variabel khusus admin jika role-nya admin
        if (Auth::user()->hasRole('admin')) {
            $viewData = array_merge($viewData, [
                'storyCounts',
                'commentCounts',
                'totalStories',
                'totalComments',
                'totalUsers',
                'categoryStats',
                'dates',
                'commentCounts',
                'anonymousData',
                'interactionDates',
                'storyTrend',
                'commentTrend',
                'voteTrend',
                'monthLabels',
                'anonymousStoryMonthly',
                'anonymousCommentMonthly',
                'growthMonths',
                'newUserCounts',
                'activeUserCounts'
            ]);
        }

        return view('dashboard.index', compact(...$viewData));
    }

    // Fitur Follow/Teman
    public function followers()
    {
        $followers = Follow::where('followed_id', Auth::id())
            ->with('follower')
            ->paginate(15);

        return view('dashboard.followers', compact('followers'));
    }

    public function following()
    {
        $following = Follow::where('follower_id', Auth::id())
            ->with('followed')
            ->paginate(15);

        return view('dashboard.following', compact('following'));
    }

    public function follow(User $user)
    {
        // Mencegah user mem-follow dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengikuti diri sendiri.');
        }

        // Cek apakah sudah follow sebelumnya
        $existingFollow = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->first();

        if (!$existingFollow) {
            // Buat follow baru
            Follow::create([
                'follower_id' => Auth::id(),
                'followed_id' => $user->id
            ]);
            return redirect()->back()->with('success', 'Berhasil mengikuti pengguna.');
        }

        return redirect()->back()->with('info', 'Anda sudah mengikuti pengguna ini.');
    }

    public function unfollow(User $user)
    {
        $deleted = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Berhasil berhenti mengikuti pengguna.');
        }

        return redirect()->back()->with('info', 'Anda belum mengikuti pengguna ini.');
    }
}
