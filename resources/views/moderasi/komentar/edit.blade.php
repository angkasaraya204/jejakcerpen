@extends('layouts.master')
@section('title', 'Ubah Komentar')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Ubah Komentar </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('comments.index') }}">Komentar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="content">Isi Komentar</label>
                    <textarea id="content" name="content"
                        class="form-control @error('content') border-red-500 @enderror">{{ old('content', $comment->content) }}</textarea>

                    @error('content')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="hidden" name="anonymous" value="0">
                        <label class="form-check-label">
                            <input type="checkbox" name="anonymous" value="1" class="form-check-input" {{ old('anonymous', $comment->anonymous) ? 'checked' : '' }}> Kirim sebagai anonim
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('comments.index') }}" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
