@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
@guest
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 bg-white border-b border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Filter Kategori</h3>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('stories.index') }}" class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300 text-sm {{ request()->missing('category') ? 'bg-blue-500 text-white' : '' }}">
                Semua
            </a>
            @foreach($categories as $category)
                <a href="{{ route('stories.index', ['category' => $category->slug]) }}" class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300 text-sm {{ request('category') == $category->slug ? 'bg-blue-500 text-white' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>
@endguest

@role('user')
<div class="page-header">
    <h3 class="page-title"> Daftar Cerita </h3>
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
                                <th> Kategori </th>
                                <th> Tanggal Dibuat </th>
                                <th> Oleh </th>
                                <th> Jumlah Komentar </th>
                                <th> Deskripsi </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stories as $story)
                                <tr>
                                    <td></td>
                                    <td>{{ $story->title }}</td>
                                    <td>{{ $story->category->name }}</td>
                                    <td>{{ $story->published_at->format('d M Y, H:i') }}
                                    </td>
                                    <td>
                                        @if($story->anonymous)
                                            Anonim
                                        @else
                                            {{ optional($story->user)->name ?? 'Anonim' }}
                                        @endif
                                    </td>
                                    <td>{{ $story->comments->count() }} komentar</td>
                                    <td>{{ Str::limit(strip_tags($story->content), 200) }}</td>
                                    <td>
                                        <a href="{{ route('stories.show', $story) }}"
                                            class="text-blue-600 hover:underline mr-3">Baca selengkapnya →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $stories->links() }}
                </div>
            @else
                <p class="text-gray-600">Belum ada cerita tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endrole
@endsection
