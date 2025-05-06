<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('user')) {
            $query = Comment::with(['user', 'story']);

            if ($request->has('story_id')) {
                $query->where('story_id', $request->input('story_id'));
            }

            $comments = $query->where('user_id', Auth::id())->latest()->paginate(10);
        } elseif (Auth::user()->hasRole(['moderator', 'admin'])) {
            $query = Comment::with(['user', 'story']);

            if ($request->has('story_id')) {
                $query->where('story_id', $request->input('story_id'));
            }

            $comments = $query->latest()->paginate(10);
        }

        return view('moderasi.komentar.index', compact('comments'));
    }

    public function store(Request $request, Story $story)
    {
        $validated = $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
            'anonymous' => 'boolean',
        ]);

        // Pastikan nilai anonymous selalu ada dengan nilai default false jika tidak ada
        $anonymous = isset($validated['anonymous']) ? true : false;

        $comment = new Comment([
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'anonymous' => $anonymous,
        ]);

        $comment->story_id = $story->id;
        $comment->user_id = Auth::check() ? Auth::id() : null;
        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function edit(Comment $comment)
    {
        return view('moderasi.komentar.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::user()->cannot('update', $comment)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }

        $validated = $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
            'anonymous' => 'boolean',
        ]);

        // Pastikan nilai anonymous selalu ada dengan nilai default false jika tidak ada
        $anonymous = isset($validated['anonymous']) ? true : false;

        $comment->update([
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? $comment->parent_id,
            'anonymous' => $anonymous,
        ]);

        return redirect()->route('stories.show', $comment->story_id)->with('success', 'Komentar berhasil diperbarui.');
    }

    public function show(Comment $comment)
    {
        $story->load(['user', 'category', 'comments' => function($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }]);

        return view('home.detail', compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        $story_id = $comment->story_id;
        $comment->delete();

        return redirect()->route('stories.show', $story_id)->with('success', 'Komentar berhasil dihapus.');
    }

    public function markSensitive(Comment $comment)
    {
        $comment->is_sensitive = !$comment->is_sensitive;
        $comment->save();

        $status = $comment->is_sensitive ? 'ditandai sebagai sensitif' : 'ditandai sebagai tidak sensitif';
        return back()->with('success', "Cerita berhasil $status.");
    }

}
