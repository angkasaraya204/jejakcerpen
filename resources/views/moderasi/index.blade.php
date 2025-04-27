@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Moderasi Cerita </h3>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Cerita Menunggu Persetujuan ({{ $pendingStories->total() }})</h4>
            @if($pendingStories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Judul </th>
                                <th> Kategori </th>
                                <th> Tanggal dibuat </th>
                                <th> Oleh </th>
                                <th> Deskripsi </th>
                                <th> Status </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingStories as $story)
                                <tr>
                                    <td></td>
                                    <td>{{ $story->title }}</td>
                                    <td>{{ $story->category->name }}</td>
                                    <td>{{ $story->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td>
                                        @if($story->anonymous)
                                            Anonim
                                        @else
                                            {{ optional($story->user)->name ?? 'Anonim' }}
                                        @endif
                                    </td>
                                    <td>
                                        <p>
                                            {{ Str::limit($story->content, 300) }}
                                            @if(strlen($story->content) > 300)
                                                <a href="{{ route('stories.show', $story) }}">
                                                    Baca selengkapnya
                                                </a>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        @if($story->is_sensitive)
                                            <span class="badge badge-danger">Sensitif</span>
                                        @else
                                            <span class="badge badge-success">Normal</span>
                                        @endif
                                    </td>
                                    @role('admin')
                                        <td>
                                            <!-- Tombol setujui hanya muncul jika konten TIDAK sensitif -->
                                            @if(!$story->is_sensitive)
                                                <form
                                                    action="{{ route('stories.approve', $story) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="approve"
                                                        class="btn btn-success">Setujui</button>
                                                </form>
                                            @endif

                                            <!-- Tombol tolak selalu muncul untuk admin -->
                                            <form action="{{ route('stories.reject', $story) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" name="action" value="reject"
                                                    class="btn btn-danger">Tolak</button>
                                            </form>
                                        </td>
                                    @endrole
                                    @role('moderator')
                                        <td>
                                            <!-- Form untuk menandai sensitif - hanya untuk moderator -->
                                            <form
                                                action="{{ route('stories.sensitive', $story) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" name="action" value="sensitive"
                                                    class="btn btn-warning">{{ $story->is_sensitive ? 'Bukan Sensitif' : 'Tandai Sensitif' }}</button>
                                            </form>
                                        </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $pendingStories->links() }}
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
