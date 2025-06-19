@extends('layouts.master')
@section('title', 'Cerita yang Dilaporkan')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Cerita yang Dilaporkan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cerita Dilaporkan</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($dilaporkan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Cerita</th>
                                <th>Alasan Pelaporan</th>
                                <th>Tanggal Laporan</th>
                                <th>Tanggal Disetujui</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dilaporkan as $dilaporkanItem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold">{{ $dilaporkanItem->reportable->title ?? 'Cerita telah dihapus' }}</span>
                                            @if($dilaporkanItem->reportable && $dilaporkanItem->reportable->user)
                                                <small class="text-muted">oleh: {{ $dilaporkanItem->reportable->user->name }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-wrap" style="max-width: 200px;">
                                            {{ $dilaporkanItem->reason }}
                                        </div>
                                    </td>
                                    <td>{{ $dilaporkanItem->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $dilaporkanItem->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="mdi mdi-check-circle"></i> Disetujui
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $dilaporkan->links() }}
                </div>
            @else
                <div class="alert alert-info">Ceritamu belum pernah dilaporkan.</div>
            @endif
        </div>
    </div>
</div>
@endsection
