@extends('layouts.master')
@section('title', 'Daftar Cerita')
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

@hasanyrole(['admin','penulis'])
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
            <div class="template-demo">
                <a href="{{ route('stories.create') }}" class="btn btn-primary btn-icon-text">
                    <i class="mdi mdi-file-check btn-icon-prepend"></i> Tambah Cerita
                </a>
            </div>
            @if($stories->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Judul Cerita </th>
                                <th> Slug </th>
                                <th> Kategori </th>
                                <th> Tanggal Dibuat </th>
                                @role('admin')
                                <th> Oleh </th>
                                {{-- MODIFICATION: Menambahkan header kolom Alias untuk admin --}}
                                <th> Alias </th>
                                <th> Jumlah Komentar </th>
                                <th> Jumlah Upvote </th>
                                <th> Jumlah Downvote </th>
                                @endrole
                                @role('penulis')
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
                                    <td>{{ $story->slug }}</td>
                                    <td>{{ $story->category->name }}</td>
                                    <td>{{ $story->created_at->format('d M Y') }}</td>
                                    @role('admin')
                                    <td>
                                        @if($story->anonymous)
                                            Anonim
                                        @else
                                            {{ optional($story->user)->name ?? 'penulis' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->anonymous)
                                            {{ optional($story->user)->name ?? 'penulis' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $story->comments->count() }} komentar</td>
                                    <td>{{ $story->votes->where('vote_type', 'upvote')->count() }} Upvote</td>
                                    <td>{{ $story->votes->where('vote_type', 'downvote')->count() }} Downvote</td>
                                    @endrole
                                    @role('penulis')
                                    <td>{{ $story->votes->where('vote_type', 'downvote')->count() }} Downvote</td>
                                    @endrole
                                    <td>{{ Str::limit(strip_tags((new \Parsedown())->text($story->content))) }}</td>
                                    @hasanyrole(['admin','penulis'])
                                    <td>
                                        <a href="{{ route('stories.edit', $story) }}"
                                            class="btn btn-primary mr-3">Ubah</a>
                                        <form action="{{ route('stories.destroy', $story) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2 mb-2">Hapus</button>
                                        </form>
                                        <a href="{{ route('stories.show', $story) }}"
                                            class="btn btn-info">Lihat</a>
                                    </td>
                                    @endhasanyrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $stories->links() }}
                </div>
            @else
                <div class="alert alert-info">Belum ada cerita tersedia.</div>
            @endif
        </div>
    </div>
</div>
@endhasanyrole
@endsection
