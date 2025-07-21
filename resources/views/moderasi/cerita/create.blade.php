@extends('layouts.master')
@section('title', 'Tambah Cerita')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Cerita </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('stories.index') }}">Cerita</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" action="{{ route('stories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Judul Cerita</label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') border-red-500 @enderror"
                        value="{{ old('title') }}" placeholder="Judul Cerita" required>

                    @error('title')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug"
                        class="form-control @error('slug') border-red-500 @enderror"
                        value="{{ old('slug') }}" placeholder="Contoh: /cerita-1/" required>

                    @error('slug')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id"
                        class="form-control @error('category_id') border-red-500 @enderror" required>
                        <option>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Isi Cerita</label>
                    <textarea id="simpleMde" name="content" class="form-control @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>

                    @error('content')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="hidden" name="anonymous" value="0">
                        <label class="form-check-label">
                            <input type="checkbox" name="anonymous" value="1" class="form-check-input" {{ old('anonymous') ? 'checked' : '' }}> Kirim sebagai anonim
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
