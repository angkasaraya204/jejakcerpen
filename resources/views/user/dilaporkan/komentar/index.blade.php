@extends('layouts.master')
@section('title', 'Komentar yang Dilaporkan')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Komentar yang Dilaporkan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dilaporkan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Komentar</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($dilaporkan->count() > 0)
                <div class="alert alert-warning mb-4">
                    <strong>Informasi:</strong> Berikut adalah komentarmu yang telah dilaporkan oleh pengguna lain dan telah disetujui oleh moderator.
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Komentar</th>
                                <th>Alasan Pelaporan</th>
                                <th>Dilaporkan Oleh</th>
                                <th>Tanggal Laporan</th>
                                <th>Tanggal Disetujui</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dilaporkan as $dilaporkanKomentar)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($dilaporkanKomentar->reportable)
                                            <div class="text-wrap" style="max-width: 300px;">
                                                {{ Str::limit($dilaporkanKomentar->reportable->content, 100) }}
                                            </div>
                                        @else
                                            <span class="text-muted">Komentar telah dihapus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">{{ $dilaporkanKomentar->reason }}</span>
                                    </td>
                                    <td>
                                        @if($dilaporkanKomentar->user)
                                            {{ $dilaporkanKomentar->user->name }}
                                            <small class="text-muted d-block">Pelapor</small>
                                        @else
                                            <span class="text-muted">Pengguna tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td>{{ $dilaporkanKomentar->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $dilaporkanKomentar->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($dilaporkanKomentar->status === 'valid')
                                            <small class="text-danger d-block mt-1">
                                                Komentar tidak sesuai dengan aturan komunitas
                                            </small>
                                        @elseif($dilaporkanKomentar->status === 'tidak-valid')
                                            <small class="text-success d-block mt-1">
                                                Komentar masih sesuai aturan komunitas
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
                    Komentar Anda belum pernah dilaporkan atau belum ada laporan yang disetujui.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
