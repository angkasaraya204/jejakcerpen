@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title">Pengikut Saya</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengikut</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Pengikut ({{ $followers->total() }})</h4>
                </div>

                @if($followers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Mengikuti Sejak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($followers as $index => $follow)
                                    <tr>
                                        <td>{{ $followers->firstItem() + $index }}</td>
                                        <td>{{ $follow->follower->name }}</td>
                                        <td>{{ $follow->follower->email }}</td>
                                        <td>{{ $follow->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('user.profile', $follow->follower->id) }}" class="btn btn-sm btn-info">
                                                <i class="mdi mdi-account-details"></i> Lihat Profil
                                            </a>

                                            @if(Auth::user()->isFollowing($follow->follower))
                                                <a href="{{ route('dashboard.unfollow', $follow->follower->id) }}" class="btn btn-sm btn-danger">
                                                    <i class="mdi mdi-account-minus"></i> Berhenti Ikuti
                                                </a>
                                            @else
                                                <a href="{{ route('dashboard.follow', $follow->follower->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="mdi mdi-account-plus"></i> Ikuti
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $followers->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        Belum ada pengikut saat ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
