<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function update(Request $request, Report $report)
    {
        $request->validate(['status' => 'required|in:valid,tidak-valid']);

        // Update status report
        $report->update(['status' => $request->status]);

        if ($request->status === 'valid') {
            // Delete the reported content (either story or comment)
            $report->reportable->delete();

            // Then delete the report itself
            // $report->delete();
        }

        return back()->with('success', 'Laporan ' . $request->status);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reportable_type' => 'required|in:story,comment',
            'reportable_id'   => 'required|integer',
            'reason'          => 'required|string',
        ]);

        // Tentukan class model
        $modelClass = $request->reportable_type === 'story'
            ? Story::class
            : Comment::class;

        // Cek apakah sudah ada
        $already = Report::where('user_id', auth()->id())
            ->where('reportable_type', $modelClass)
            ->where('reportable_id', $request->reportable_id)
            ->exists();

        if ($already) {
            return back()->with('error', 'Anda sudah melaporkan cerita ini sebelumnya.');
        }

        // Jika belum, buat laporan
        Report::create([
            'user_id'          => auth()->id(),
            'reportable_type'  => $modelClass,
            'reportable_id'    => $request->reportable_id,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        return back()->with('success', 'Cerita berhasil dilaporkan!');
    }

    public function storiesmelaporkan(Story $story)
    {
        // Ambil laporan cerita yang dibuat oleh user yang sedang login
        $melaporkan = Report::with('reportable.user')
            ->where('user_id', auth()->id())
            ->where('reportable_type', Story::class)
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('user.melaporkan.cerita.index', compact('melaporkan'));
    }
    public function commentmelaporkan(Comment $comment)
    {
        // Ambil laporan cerita yang dibuat oleh user yang sedang login
        $melaporkan = Report::with('reportable.user')
            ->where('user_id', auth()->id())
            ->where('reportable_type', Comment::class)
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('user.melaporkan.komentar.index', compact('melaporkan'));
    }

    public function storiesdilaporkan()
    {
        $dilaporkan = Report::with('reportable.user')
            ->where('reportable_type', Story::class)
            ->where('status', 'valid')
            ->whereHas('reportable', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        return view('user.dilaporkan.cerita.index', compact('dilaporkan'));
    }
    public function commentdilaporkan(Comment $comment)
    {
        $dilaporkan = Report::with('reportable.user')
            ->where('reportable_type', Comment::class)
            ->where('status', 'valid')
            ->whereHas('reportable', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        return view('user.dilaporkan.komentar.index', compact('dilaporkan'));
    }
}
