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
                                <th>Oleh: </th>
                                <th>Tanggal Laporan</th>
                                <th>Tanggal Disetujui</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dilaporkan as $dilaporkanItem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $dilaporkanItem->reportable->title ?? 'Cerita telah dihapus' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">{{ $dilaporkanItem->reason }}</span>
                                    </td>
                                    <td>
                                        @if($dilaporkanItem->reportable && $dilaporkanItem->reportable->user)
                                            {{ $dilaporkanItem->reportable->user->name }}
                                        @endif
                                    </td>
                                    <td>{{ $dilaporkanItem->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $dilaporkanItem->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span>Maaf Ceritamu Tidak Sesuai Dengan Aturan Kami</span>
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
