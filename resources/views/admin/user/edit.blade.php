@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Ubah Pengguna </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" action="{{ route('users.update', $user) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" placeholder="Nama Pengguna">

                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" placeholder="Email Pengguna">

                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    @foreach($roles as $role)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" {{ $user->hasRole($role->name) ? 'checked' : '' }}> {{ ucfirst($role->name) }} </label>
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection
