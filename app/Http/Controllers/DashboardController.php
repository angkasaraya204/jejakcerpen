<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vote;
use App\Models\Story;
use App\Models\Follow;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasAnyRole(['admin', 'moderator'])) {
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

        // Set data default untuk user
        $followingCount = $followingCount ?? 0;
        $followersCount = $followersCount ?? 0;
        $upvotesReceived = $upvotesReceived ?? 0;
        $downvotesReceived = $downvotesReceived ?? 0;
        $monthlyLabels = $monthlyLabels ?? [];
        $storyMonthly = $storyMonthly ?? [];
        $commentMonthly = $commentMonthly ?? [];
        $voteMonthly = $voteMonthly ?? [];

        return view('dashboard.index', compact(
            'totalStories',
            'pendingStories',
            'approvedStories',
            'rejectedStories',
            'totalUsers',
            'totalComments',
            'dates',
            'storyCounts',
            'commentCounts',
            'categoryStats',
            'followingCount',
            'followersCount',
            'upvotesReceived',
            'downvotesReceived',
            'monthlyLabels',
            'storyMonthly',
            'commentMonthly',
            'voteMonthly'
        ));
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

        if ($existingFollow) {
            return redirect()->back()->with('info', 'Anda sudah mengikuti pengguna ini.');
        }

        // Buat follow baru
        Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Berhasil mengikuti pengguna.');
    }

    public function unfollow(User $user)
    {
        Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->delete();

        return redirect()->back()->with('success', 'Berhasil berhenti mengikuti pengguna.');
    }
}
