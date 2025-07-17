@extends('layouts.master')
@section('title', 'Ubah Cerita')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Ubah Cerita </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('stories.index') }}">Cerita</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" action="{{ route('stories.update', $story) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="title">Judul Cerita</label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') border-red-500 @enderror"
                        value="{{ old('title', $story->title) }}" placeholder="Judul Cerita" required>

                    @error('title')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id"
                        class="form-control @error('category_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $story->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Isi Cerita</label>
                    <textarea id="simpleMde" name="content" class="form-control @error('content') border-red-500 @enderror">{{ old('content', $story->content) }}</textarea>

                    @error('content')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="anonymous" class="form-check-input" {{ old('anonymous', $story->anonymous) ? 'checked' : '' }}> Kirim sebagai anonim
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('stories.index') }}" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
