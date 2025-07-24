@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Daftar Kategori </h3>
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
            <div class="template-demo">
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-icon-text">
                    <i class="mdi mdi-file-check btn-icon-prepend"></i> Tambah Kategori
                </a>
            </div>
            @if($categories->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Nama </th>
                                <th> Slug </th>
                                <th> Jumlah Cerita </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->stories_count }}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary mr-3">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2 mb-2" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $stories->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Belum ada kategori tersedia.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
