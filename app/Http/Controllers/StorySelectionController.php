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

    public function bulkAction(Request $request)
    {
        $request->validate([
            'story_ids'   => 'required|array',
            'story_ids.*' => 'exists:stories,id',
            'action'      => 'required|in:approve,reject',
        ]);

        $storyIds = $request->input('story_ids');
        $action = $request->input('action');
        $message = 'Tidak ada aksi yang dilakukan.';

        if ($action == 'approve') {
            Story::whereIn('id', $storyIds)->update(['status' => 'approved']);
            $message = 'Cerita yang dipilih berhasil disetujui.';
        } elseif ($action == 'reject') {
            Story::whereIn('id', $storyIds)->update(['status' => 'rejected']);
            $message = 'Cerita yang dipilih berhasil ditolak.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function approve(Story $story)
    {
        $story->update(['status' => 'approved']);
        return back()->with('success', 'Cerita telah disetujui dan dipublikasikan.');
    }

    public function reject(Story $story)
    {
        $story->update(['status' => 'rejected']);
        return back()->with('error', 'Cerita telah ditolak.');
    }
}
