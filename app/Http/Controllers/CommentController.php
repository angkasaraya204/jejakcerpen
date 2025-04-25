<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Story $story)
    {
        $validated = $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
            'anonymous' => 'boolean',
        ]);

        $comment = new Comment($validated);
        $comment->story_id = $story->id;
        $comment->user_id = Auth::check() ? Auth::id() : null;
        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy(Comment $comment)
    {
        $story_id = $comment->story_id;
        $comment->delete();

        return redirect()->route('stories.show', $story_id)->with('success', 'Komentar berhasil dihapus.');
    }
}
