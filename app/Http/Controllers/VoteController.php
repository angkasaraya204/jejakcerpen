<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request, Story $story)
    {
        $validated = $request->validate([
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        $userId = Auth::check() ? Auth::id() : null;
        if (!$userId) {
            session()->put('vote_' . $story->id, $validated['vote_type']);
            return redirect()->back()->with('info', 'Vote direkam dalam sesi. Login untuk permanen.');
        }

        $vote = Vote::where('user_id', $userId)
                    ->where('story_id', $story->id)
                    ->first();

        if ($vote) {
            if ($vote->vote_type === $validated['vote_type']) {
                $vote->delete();
                return redirect()->back()->with('success', 'Vote dihapus.');
            } else {
                $vote->vote_type = $validated['vote_type'];
                $vote->save();
                return redirect()->back()->with('success', 'Vote diubah.');
            }
        } else {
            Vote::create([
                'user_id' => $userId,
                'story_id' => $story->id,
                'vote_type' => $validated['vote_type'],
            ]);
            return redirect()->back()->with('success', 'Anda telah memberikan suara.');
        }
    }
}
