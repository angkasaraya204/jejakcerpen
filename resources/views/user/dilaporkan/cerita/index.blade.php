@extends('layouts.master')
@section('title', 'Cerita yang Dilaporkan')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Cerita yang Dilaporkan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dilaporkan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cerita</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($dilaporkan->count() > 0)
                <div class="alert alert-warning mb-4">
                    <strong>Informasi:</strong> Berikut adalah ceritamu yang telah dilaporkan oleh pengguna lain dan telah disetujui oleh moderator.
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Cerita</th>
                                <th>Alasan Pelaporan</th>
                                <th>Dilaporkan Oleh</th>
                                <th>Tanggal Laporan</th>
                                <th>Tanggal Disetujui</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dilaporkan as $dilaporkanCerita)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($dilaporkanCerita->reportable)
                                            {{ $dilaporkanCerita->reportable->title }}
                                        @else
                                            <span class="text-muted">Cerita telah dihapus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">{{ $dilaporkanCerita->reason }}</span>
                                    </td>
                                    <td>
                                        @if($dilaporkanCerita->user)
                                            {{ $dilaporkanCerita->user->name }}
                                            <small class="text-muted d-block">Pelapor</small>
                                        @else
                                            <span class="text-muted">Pengguna tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td>{{ $dilaporkanCerita->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $dilaporkanCerita->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($dilaporkanCerita->status === 'valid')
                                            <small class="text-danger d-block mt-1">
                                                Cerita tidak sesuai dengan aturan komunitas
                                            </small>
                                        @elseif($dilaporkanCerita->status === 'tidak-valid')
                                            <small class="text-success d-block mt-1">
                                                Cerita masih sesuai aturan komunitas
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $dilaporkan->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Cerita Anda belum pernah dilaporkan atau belum ada laporan yang disetujui.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
