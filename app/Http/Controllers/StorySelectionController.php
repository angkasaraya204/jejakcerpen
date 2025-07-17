<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StorySelectionController extends Controller
{
    public function index()
    {
        $stories = Story::where('status', 'pending')->latest()->paginate(10);
        return view('admin.seleksi-cerita.index', compact('stories'));
    }

    public function approve(Story $story)
    {
        $story->update(['status' => 'approved']);
        return back()->with('success', 'Cerita telah disetujui dan dipublikasikan.');
    }

    public function reject(Story $story)
    {
        $story->update(['status' => 'rejected']);
        return back()->with('danger', 'Cerita telah ditolak.');
    }
}
