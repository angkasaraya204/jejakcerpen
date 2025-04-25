<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guest()) {
            $query = Story::with(['user', 'category'])->where('status', 'approved');

            if ($request->has('category')) {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            $stories = $query->latest('published_at')->paginate(10);
            $categories = Category::all();
        } elseif (Auth::user()->hasRole('user')) {
            $query = Story::with(['user', 'category'])->where('status', 'approved');

            if ($request->has('category')) {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            $stories = $query->where('user_id', Auth::id())->latest('published_at')->paginate(10);
            $categories = Category::all();
        }

        return view('stories.index', compact('stories', 'categories'));
    }

    public function show(Story $story)
    {
        if ($story->status !== 'approved' && (Auth::guest() || !Auth::user()->hasRole('admin'))) {
            abort(404);
        }

        $story->load(['user', 'category', 'comments' => function($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }]);

        return view('stories.show', compact('story'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('stories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'anonymous' => 'boolean',
        ]);

        $story = new Story($validated);
        $story->status = 'pending';
        $story->user_id = Auth::id();
        $story->save();

        return back()->with('success', 'Cerita telah dikirim dan menunggu persetujuan.');
    }

    public function moderate()
    {
        $pendingStories = Story::with(['user', 'category'])->where('status', 'pending')->latest()->paginate(10);
        return view('stories.moderate', compact('pendingStories'));
    }

    public function approve(Story $story)
    {
        $story->status = 'approved';
        $story->published_at = now();
        $story->save();

        return redirect()->route('stories.moderate')->with('success', 'Cerita berhasil disetujui dan dipublikasikan.');
    }

    public function reject(Story $story)
    {
        $story->status = 'rejected';
        $story->save();

        return redirect()->route('stories.moderate')->with('success', 'Cerita ditolak.');
    }

    public function markSensitive(Story $story)
    {
        $story->is_sensitive = !$story->is_sensitive;
        $story->save();

        $status = $story->is_sensitive ? 'ditandai sebagai sensitif' : 'ditandai sebagai tidak sensitif';
        return back()->with('success', "Cerita berhasil $status.");
    }
}
