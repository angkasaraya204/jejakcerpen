@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Ubah Kategori </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" action="{{ route('categories.update', $category) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') border-red-500 @enderror" value="{{ old('name', $category->name) }}" placeholder="Nama Kategori">

                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug"
                        class="form-control @error('slug') border-red-500 @enderror" value="{{ old('slug', $category->slug) }}" placeholder="Contoh: /horror/">

                    @error('slug')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('categories.index') }}" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
