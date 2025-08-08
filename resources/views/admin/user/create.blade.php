@extends('layouts.master')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Pengguna </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}" placeholder="Nama Pengguna" required>

                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" placeholder="Email Pengguna" required>

                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') border-red-500 @enderror"
                        placeholder="Password" required>

                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Konfirmasi Password" required>

                    @error('password_confirmation')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Peran</label>
                    @foreach($roles as $role)
                        <div class="form-check">
                            <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}
                                <input type="checkbox" id="role-{{ $role->id }}" name="roles[]" value="{{ $role->name }}" class="form-check-input @error('roles') border-red-500 @enderror" {{ collect(old('roles'))->contains($role->name) ? 'checked' : '' }}>
                            </label>
                        </div>
                    @endforeach
                    @error('roles')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('users.index') }}" class="btn btn-dark">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
