@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title">Pengguna yang Saya Ikuti</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mengikuti</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Pengguna yang Diikuti ({{ $following->total() }})</h4>
                </div>

                @if($following->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Diikuti Sejak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($following as $index => $follow)
                                    <tr>
                                        <td>{{ $following->firstItem() + $index }}</td>
                                        <td>{{ $follow->followed->name }}</td>
                                        <td>{{ $follow->followed->email }}</td>
                                        <td>{{ $follow->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.unfollow', $follow->followed->id) }}" class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-account-minus"></i> Berhenti Ikuti
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $following->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        Anda belum mengikuti pengguna manapun.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
