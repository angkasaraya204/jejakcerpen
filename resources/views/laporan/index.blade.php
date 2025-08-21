@extends('layouts.master')
@section('title', 'Daftar Laporan')
@section('content')

{{-- Alert Section --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@role('admin')
<div class="page-header">
    <h3 class="page-title"> Daftar Laporan </h3>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Nama </th>
                                <th> Tipe </th>
                                <th> Judul </th>
                                <th> Alasan </th>
                                <th> Status </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $report->reportable->user->name ?? '—' }}</td>
                                    <td>
                                        @if($report->reportable_type === 'App\Models\Story')
                                            <span class="badge bg-primary text-white">Cerita</span>
                                        @else
                                            <span class="badge bg-secondary">Komentar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($report->reportable_type === 'App\Models\Story')
                                            {{ $report->reportable->title ?? 'Cerita telah dihapus' }}
                                        @elseif($report->reportable_type === 'App\Models\Comment')
                                            {{ $report->reportable->story->title ?? 'Komentar telah dihapus' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-danger text-white">{{ $report->reason }}</span>
                                    </td>
                                    <td>
                                        @if ($report->status === 'valid')
                                            <span class="badge bg-danger text-white">Disetujui</span>
                                        @elseif ($report->status === 'tidak-valid')
                                            <span class="badge bg-success text-white">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-white">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($report->status === 'pending')
                                            <form action="{{ route('reports.update', $report) }}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="status" value="valid">
                                                <button type="submit" class="btn btn-danger">Setujui</button>
                                            </form>
                                            <form action="{{ route('reports.update', $report) }}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="status" value="tidak-valid">
                                                <button type="submit" class="btn btn-success mt-2">Tolak</button>
                                            </form>
                                        @else
                                            <span class="badge bg-info text-white">Tindakan telah diambil</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $reports->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Belum ada laporan tersedia.
                </div>
            @endif
        </div>
    </div>
</div>
@endrole
@endsection
