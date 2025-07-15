<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vote;
use App\Models\Story;
use App\Models\Views;
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

            // NEW: Anonymous vs. Non-Anonymous Posts distribution
            $anonymousStories = Story::where('anonymous', true)->count();
            $nonAnonymousStories = Story::where('anonymous', false)->count();
            $anonymousData = [$anonymousStories, $nonAnonymousStories];

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

            // Data cerita yang dibaca per kategori untuk SEMUA PENGGUNA
            $readStoriesPerCategory = Views::join('stories', 'stories_views.story_id', '=', 'stories.id')
                ->join('categories', 'stories.category_id', '=', 'categories.id')
                ->select('categories.name as category_name', DB::raw('COUNT(*) as total_reads'))
                ->groupBy('categories.id', 'categories.name')
                ->orderBy('total_reads', 'desc')
                ->get();

            // Pastikan data tidak kosong sebelum di-pass ke view
            $categoryReadLabels = $readStoriesPerCategory->pluck('category_name')->toArray();
            $categoryReadCounts = $readStoriesPerCategory->pluck('total_reads')->toArray();

            // Data Minggu (7 hari terakhir)
            $weekStart = Carbon::now()->subDays(6)->startOfDay();
            $weekLabels = [];
            $weekStories = [];
            $weekComments = [];
            $weekVotes = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $weekStart->copy()->addDays($i);
                $weekLabels[] = $date->format('d/m');

                $weekStories[] = Story::whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $weekComments[] = Comment::whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $weekVotes[] = Vote::whereDate('created_at', $date->format('Y-m-d'))
                    ->count();
            }

            // Data Bulan (30 hari terakhir)
            $monthStart = Carbon::now()->subDays(29)->startOfDay();
            $monthLabels = [];
            $monthStories = [];
            $monthComments = [];
            $monthVotes = [];

            for ($i = 0; $i < 30; $i++) {
                $date = $monthStart->copy()->addDays($i);
                $monthLabels[] = $date->format('d/m');

                $monthStories[] = Story::whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $monthComments[] = Comment::whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $monthVotes[] = Vote::whereDate('created_at', $date->format('Y-m-d'))
                    ->count();
            }

            // Data Tahun (12 bulan terakhir)
            $yearLabels = [];
            $yearStories = [];
            $yearComments = [];
            $yearVotes = [];

            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $yearLabels[] = $date->format('M Y');

                $yearStories[] = Story::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();

                $yearComments[] = Comment::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();

                $yearVotes[] = Vote::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }

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
        } elseif (Auth::user()->hasRole('user')) {
            $userId = Auth::id();

            $totalStories = Story::where('user_id', $userId)->count();
            $totalComments = Comment::where('user_id', $userId)->count();

            // Data cerita yang dibaca user per kategori
            $readStoriesPerCategory = Views::join('stories', 'stories_views.story_id', '=', 'stories.id')
                ->join('categories', 'stories.category_id', '=', 'categories.id')
                ->where('stories_views.user_id', $userId)
                ->select('categories.name as category_name', DB::raw('COUNT(*) as total_reads'))
                ->groupBy('categories.id', 'categories.name')
                ->orderBy('total_reads', 'desc')
                ->get();

            // Data pengunjung per kategori (untuk perbandingan)
            $visitorStoriesPerCategory = Views::join('stories', 'stories_views.story_id', '=', 'stories.id')
                ->join('categories', 'stories.category_id', '=', 'categories.id')
                ->select('categories.name as category_name', DB::raw('COUNT(*) as total_views'))
                ->groupBy('categories.id', 'categories.name')
                ->orderBy('total_views', 'desc')
                ->get();

            // Pastikan data tidak kosong sebelum di-pass ke view
            $categoryReadLabels = $readStoriesPerCategory->pluck('category_name')->toArray();
            $categoryReadCounts = $readStoriesPerCategory->pluck('total_reads')->toArray();

            // Tambahan untuk fitur Follow/Teman
            $followingCount = Follow::where('follower_id', $userId)->count();
            $followersCount = Follow::where('followed_id', $userId)->count();

            // Statistik Interaksi
            $upvotesReceived = Vote::join('stories', 'votes.story_id', '=', 'stories.id')
                ->where('stories.user_id', $userId)
                ->where('votes.vote_type', 'upvote')
                ->count();

            $downvotesReceived = Vote::join('stories', 'votes.story_id', '=', 'stories.id')
                ->where('stories.user_id', $userId)
                ->where('votes.vote_type', 'downvote')
                ->count();

            $commentReceived = Comment::join('stories', 'comments.story_id', '=', 'stories.id')
                ->where('stories.user_id', $userId)
                ->where('comments.parent_id', null)
                ->count();

            // Data Minggu (7 hari terakhir)
            $weekStart = Carbon::now()->subDays(6)->startOfDay();
            $weekLabels = [];
            $weekStories = [];
            $weekComments = [];
            $weekVotes = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $weekStart->copy()->addDays($i);
                $weekLabels[] = $date->format('d/m');

                $weekStories[] = Story::where('user_id', $userId)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $weekComments[] = Comment::where('user_id', $userId)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $weekVotes[] = Vote::where('user_id', $userId)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();
            }

            // Data Bulan (30 hari terakhir)
            $monthStart = Carbon::now()->subDays(29)->startOfDay();
            $monthLabels = [];
            $monthStories = [];
            $monthComments = [];
            $monthVotes = [];

            for ($i = 0; $i < 30; $i++) {
                $date = $monthStart->copy()->addDays($i);
                $monthLabels[] = $date->format('d/m');

                $monthStories[] = Story::where('user_id', $userId)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $monthComments[] = Comment::where('user_id', $userId)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $monthVotes[] = Vote::where('user_id', $userId)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();
            }

            // Data Tahun (12 bulan terakhir)
            $yearLabels = [];
            $yearStories = [];
            $yearComments = [];
            $yearVotes = [];

            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $yearLabels[] = $date->format('M Y');

                $yearStories[] = Story::where('user_id', $userId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();

                $yearComments[] = Comment::where('user_id', $userId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();

                $yearVotes[] = Vote::where('user_id', $userId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }
        }

        // Set data default untuk user
        $followingCount = $followingCount ?? 0;
        $followersCount = $followersCount ?? 0;
        $upvotesReceived = $upvotesReceived ?? 0;
        $downvotesReceived = $downvotesReceived ?? 0;
        $commentReceived = $commentReceived ?? 0;

        // Menyiapkan variabel untuk compact berdasarkan role
        $viewData = [];

        // Tambahkan variabel khusus user jika role-nya user
        if (Auth::user()->hasRole('user')) {
            $viewData = array_merge($viewData, [
                'totalStories',
                'totalComments',
                'followingCount',
                'followersCount',
                'upvotesReceived',
                'downvotesReceived',
                'commentReceived',
                'weekLabels',
                'weekStories',
                'weekComments',
                'weekVotes',
                'monthLabels',
                'monthStories',
                'monthComments',
                'monthVotes',
                'yearLabels',
                'yearStories',
                'yearComments',
                'yearVotes',
                'categoryReadLabels',
                'categoryReadCounts',
                'visitorStoriesPerCategory'
            ]);
        }

        // Tambahkan variabel khusus admin jika role-nya admin
        if (Auth::user()->hasRole('admin')) {
            $viewData = array_merge($viewData, [
                'totalStories',
                'totalComments',
                'totalUsers',
                'anonymousData',
                'growthMonths',
                'newUserCounts',
                'activeUserCounts',
                'categoryReadLabels',
                'categoryReadCounts',
                'weekLabels',
                'weekStories',
                'weekComments',
                'weekVotes',
                'monthLabels',
                'monthStories',
                'monthComments',
                'monthVotes',
                'yearLabels',
                'yearStories',
                'yearComments',
                'yearVotes',
                'storyReportsPending',
                'storyReportsValid',
                'storyReportsInvalid',
                'commentReportsPending',
                'commentReportsValid',
                'commentReportsInvalid',
                'reportsPerDay'
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
