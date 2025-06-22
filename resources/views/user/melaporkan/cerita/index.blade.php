@extends('layouts.master')
@section('title', 'Melaporkan Cerita')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Melaporkan Cerita </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Melaporkan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cerita</li>
        </ol>
    </nav>
</div>
<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($melaporkan->count() > 0)
                <div class="alert alert-warning mb-4">
                    <strong>Informasi:</strong> Berikut adalah laporanmu terhadap cerita pengguna lain dan telah disetujui oleh moderator.
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Cerita</th>
                                <th>Alasan Pelaporan</th>
                                {{-- <th>Melaporkan</th> --}}
                                <th>Tanggal Laporan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($melaporkan as $melaporkanItem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $melaporkanItem->reportable->title ?? 'Cerita telah dihapus' }}</td>
                                    <td>
                                        <span class="badge badge-danger">{{ $melaporkanItem->reason }}</span>
                                    </td>
                                    {{-- <td>
                                        @if($melaporkanItem->user)
                                            {{ $melaporkanItem->user->name }}
                                        @else
                                            <span class="text-muted">Pengguna tidak ditemukan</span>
                                        @endif
                                    </td> --}}
                                    <td>{{ $melaporkanItem->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($melaporkanItem->status == 'valid')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($melaporkanItem->status == 'tidak-valid')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $melaporkan->links() }}
                </div>
            @else
                <div class="alert alert-info">Belum ada laporan cerita yang Anda kirim.</div>
            @endif
        </div>
    </div>
</div>
@endsection
