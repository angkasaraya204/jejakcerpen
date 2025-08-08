<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Views;
use App\Models\Follow;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('user')) {
            $query = Story::with(['user', 'category'])->where('status', 'approved');

            $stories = $query->where('user_id', Auth::id())->latest('created_at')->paginate(10);
            $categories = Category::all();
            return view('moderasi.cerita.index', compact('stories'));
        } elseif (Auth::user()->hasRole('admin')) {
            $query = Story::with(['user', 'category'])->where('status', 'approved');

            $stories = $query->latest('created_at')->paginate(10);
            $categories = Category::all();

            return view('moderasi.cerita.index', compact('stories'));
        }
    }

    public function show(Story $story)
    {
       if (Auth::check()) {
            Views::updateOrCreate(
                ['story_id' => $story->id, 'user_id' => Auth::id()]
            );
        } else {
            $viewedStories = Session::get('viewed_stories', []);

            if (!in_array($story->id, $viewedStories)) {
                Views::create([
                    'story_id' => $story->id,
                    'user_id' => null // user_id dikosongkan untuk guest
                ]);

                Session::push('viewed_stories', $story->id);
            }
        }

        $story->load(['user', 'category', 'comments' => function($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }]);

        return view('home.detail', compact('story'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('moderasi.cerita.create', compact('categories'));
    }

    public function store(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|regex:/^[a-z0-9\/\-]+$/|max:50|unique:stories,slug,' . $story->id,
            'content' => 'required|max:10000',
            'category_id' => 'required|exists:categories,id',
            'anonymous' => 'boolean',
        ]);

        $story = new Story([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'anonymous' => $validated['anonymous'] ?? false,
            'status' => 'pending',
        ]);

        $story->user_id = Auth::id();
        $story->save();

        return redirect()->route('stories.index')->with('success', 'Cerita menunggu persetujuan admin.');
    }

    public function edit(Story $story)
    {
        $categories = Category::all();
        return view('moderasi.cerita.edit', compact('story', 'categories'));
    }

    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|regex:/^[a-z0-9\/\-]+$/|max:50|unique:stories,slug,' . $story->id,
            'content' => 'required|max:10000',
            'category_id' => 'required|exists:categories,id',
            'anonymous' => 'boolean',
        ]);

        $story->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'anonymous' => $validated['anonymous'] ?? false,
        ]);

        return redirect()->route('stories.index')->with('success', 'Cerita telah diperbarui.');
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return back()->with('success', 'Cerita berhasil dihapus.');
    }
}
