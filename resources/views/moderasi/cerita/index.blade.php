@extends('layouts.master')
@section('title', 'Dashboard')
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

@hasanyrole(['admin','user'])
<div class="page-header">
    <h3 class="page-title"> Daftar Cerita </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Moderasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cerita</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @role('user')
            <div class="template-demo">
                <a href="{{ route('stories.create') }}" class="btn btn-primary btn-icon-text">
                    <i class="mdi mdi-file-check btn-icon-prepend"></i> Tambah Cerita
                </a>
            </div>
            @endrole
            @if($stories->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Judul Cerita </th>
                                <th> Kategori </th>
                                <th> Tanggal Dibuat </th>
                                @role('admin')
                                <th> Oleh </th>
                                <th> Jumlah Komentar </th>
                                <th> Jumlah Upvote </th>
                                <th> Jumlah Downvote </th>
                                @endrole
                                @role('user')
                                <th> Jumlah Downvote </th>
                                @endrole
                                <th> Deskripsi </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stories as $story)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $story->title }}</td>
                                    <td>{{ $story->category->name }}</td>
                                    <td>{{ $story->created_at->format('d M Y, H:i') }}</td>
                                    @role('admin')
                                    <td>
                                        @if($story->anonymous)
                                            Anonim
                                        @else
                                            {{ optional($story->user)->name ?? 'User' }}
                                        @endif
                                    </td>
                                    <td>{{ $story->comments->count() }} komentar</td>
                                    <td>{{ $story->votes->where('vote_type', 'upvote')->count() }} Upvote</td>
                                    <td>{{ $story->votes->where('vote_type', 'downvote')->count() }} Downvote</td>
                                    @endrole
                                    @role('user')
                                    <td>{{ $story->votes->where('vote_type', 'downvote')->count() }} Downvote</td>
                                    @endrole
                                    <td>{{ Str::limit(strip_tags($story->content), 200) }}</td>
                                    @hasanyrole(['admin','user'])
                                    <td>
                                        <a href="{{ route('stories.edit', $story) }}"
                                            class="btn btn-primary mr-3">Ubah</a>
                                        <form action="{{ route('stories.destroy', $story) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2 mb-2">Hapus</button>
                                        </form>
                                        <a href="{{ route('stories.show', $story) }}"
                                            class="text-blue-600 hover:underline">Baca selengkapnya →</a>
                                    </td>
                                    @endhasanyrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $stories->links() }}
                </div>
            @else
                <div class="alert alert-info">Belum ada cerita tersedia.</div>
            @endif
        </div>
    </div>
</div>
@endhasanyrole

@role('moderator')
<div class="page-header">
    <h3 class="page-title"> Daftar Laporan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        </ol>
    </nav>
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
                                <th> Judul Cerita </th>
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
                                            {{ $report->reportable->title ?? '—' }}
                                        @elseif($report->reportable_type === 'App\Models\Comment')
                                            {{ $report->reportable->story->title ?? '—' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-danger text-white">{{ $report->reason }}</span>
                                    </td>
                                    <td>
                                        @if ($report->status === 'valid')
                                            <span class="badge bg-danger text-white">Valid</span>
                                        @elseif ($report->status === 'tidak-valid')
                                            <span class="badge bg-success text-white">Tidak Valid</span>
                                        @else
                                            <span class="badge bg-warning text-white">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('reports.update', $report) }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="valid">
                                            <button type="submit" class="btn btn-danger">Valid (Hapus)</button>
                                        </form>
                                        <form action="{{ route('reports.update', $report) }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="tidak-valid">
                                            <button type="submit" class="btn btn-success mt-2">Tidak Valid</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @else
                <p class="text-gray-600">Belum ada laporan tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endrole
@endsection
