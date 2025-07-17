@extends('layouts.master')
@section('title', 'Seleksi Cerita')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Seleksi Cerita </h3>
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
            @if($stories->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Judul </th>
                                <th> Penulis </th>
                                <th> Kategori </th>
                                <th> Tanggal Kirim </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stories as $story)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> {{ $story->title }} </td>
                                    <td> {{ $story->user->name }} </td>
                                    <td> {{ $story->category->name }} </td>
                                    <td> {{ $story->created_at->format('d M Y') }} </td>
                                    <td>
                                        <a href="{{ route('stories.show', $story) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                        <form action="{{ route('story-selections.approve', $story) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                        </form>
                                        <form action="{{ route('story-selections.reject', $story) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $stories->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Tidak ada cerita yang menunggu persetujuan.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
