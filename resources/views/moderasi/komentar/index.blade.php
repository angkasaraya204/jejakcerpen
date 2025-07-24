@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

<div class="page-header">
    <h3 class="page-title"> Daftar Komentar </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Moderasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Komentar</li>
        </ol>
    </nav>
</div>

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

<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($comments->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Komentar </th>
                                <th> Tanggal Dibuat </th>
                                <th> Oleh </th>
                                {{-- MODIFICATION: Menambahkan header kolom Alias untuk admin --}}
                                @role('admin')
                                <th> Alias </th>
                                @endrole
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit(strip_tags($comment->content), 100) }}</td>
                                    <td>{{ $comment->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        @if($comment->anonymous)
                                            Anonim
                                        @else
                                            {{ optional($comment->user)->name ?? 'Anonim' }}
                                        @endif
                                    </td>
                                    {{-- MODIFICATION: Menambahkan data untuk kolom Alias untuk admin --}}
                                    @role('admin')
                                    <td>
                                        @if($comment->anonymous)
                                            {{ optional($comment->user)->name ?? 'Anonim' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @endrole
                                    <td>
                                        @hasanyrole(['admin','user'])
                                        <a href="{{ route('comments.edit', $comment) }}" class="btn btn-primary mr-3">Ubah</a>
                                        @endhasanyrole
                                        @hasanyrole(['admin','moderator','user'])
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2 mb-2">Hapus</button>
                                        </form>
                                        <a href="{{ route('stories.show', $comment->story) }}" class="text-blue-600 hover:underline">
                                            Baca selengkapnya →
                                        </a>
                                        @endhasanyrole
                                        @role('moderator')
                                        <a href="{{ route('stories.sensitive', $story->story) }}" class="btn btn-warning mr-3">Tandai Sensitif</a>
                                        @endrole
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $comments->links() }}
                </div>
            @else
                <div class="alert alert-info">Belum ada komentar tersedia.</div>
            @endif
        </div>
    </div>
</div>
@endsection
