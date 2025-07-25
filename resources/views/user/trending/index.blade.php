@extends('layouts.master')
@section('title', 'Ceritaku Trending')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Ceritaku Trending </h3>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($trendingStories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Cerita</th>
                                <th>Jumlah Upvote</th>
                                <th>Jumlah Komentar</th>
                                <th>Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trendingStories as $story)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $story->title }}</td>
                                    <td>{{ $story->upvotes_count }}</td>
                                    <td>{{ $story->comments->count() }} komentar</td>
                                    <td>{{ $story->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $trendingStories->links() }}
                </div>
            @else
                <div class="alert alert-info">Belum ada ceritamu yang trending.</div>
            @endif
        </div>
    </div>
</div>
@endsection
