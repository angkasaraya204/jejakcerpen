@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Daftar Pengguna </h3>
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
            @if($users->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Nama </th>
                                <th> Email </th>
                                <th> Peran </th>
                                <th> Tanggal Daftar </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary mr-3">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mt-2 mb-2" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $stories->links() }}
                </div>
                <div class="text-center mt-2">
                    <small class="text-muted">
                        Showing {{ $stories->firstItem() }} to {{ $stories->lastItem() }} of {{ $stories->total() }} results
                    </small>
                </div>
            @else
                <div class="alert alert-info">
                    Belum ada pengguna terdaftar.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
