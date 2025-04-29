@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Statistik Platform </h3>
</div>
@role('admin')
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalStories }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Cerita</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $pendingStories }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Cerita Menunggu</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $approvedStories }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Cerita Dipublikasi</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $rejectedStories }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Cerita Ditolak</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalUsers }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Pengguna</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalComments }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Komentar</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas 7 Hari Terakhir</h4>
                    <canvas id="activityChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Distribusi Kategori</h4>
                    <canvas id="categoryChart" style="height:100px"></canvas>
                </div>
            </div>
        </div>
    </div>
@endrole

@role('user')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalStories }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Cerita</h6>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalComments }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Komentar</h6>
                </div>
            </div>
        </div>

        <!-- Tambahan untuk fitur Follow/Teman -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $followingCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Mengikuti</h6>
                    <a href="{{ route('dashboard.following') }}" class="btn btn-sm btn-primary mt-2">Lihat</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $followersCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pengikut</h6>
                    <a href="{{ route('dashboard.followers') }}" class="btn btn-sm btn-primary mt-2">Lihat</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Profil dan Dashboard Aktivitas Pribadi -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas 7 Hari Terakhir</h4>
                    <canvas id="activityChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Interaksi</h4>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Upvotes Diterima:</span>
                                <span class="badge badge-success">{{ $upvotesReceived }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Downvotes Diterima:</span>
                                <span class="badge badge-danger">{{ $downvotesReceived }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $upvotesReceived + $downvotesReceived > 0 ? ($upvotesReceived / ($upvotesReceived + $downvotesReceived) * 100) : 0 }}%"
                                    aria-valuenow="{{ $upvotesReceived }}" aria-valuemin="0"
                                    aria-valuemax="{{ $upvotesReceived + $downvotesReceived }}">
                                    {{ $upvotesReceived + $downvotesReceived > 0 ? round(($upvotesReceived / ($upvotesReceived + $downvotesReceived) * 100), 1) : 0 }}%
                                </div>
                            </div>
                            <small class="text-muted">Rasio Upvote/Downvote</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Aktivitas -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pola Partisipasi Bulanan</h4>
                    <canvas id="monthlyActivityChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>
@endrole
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Activity Chart
            const activityCtx = document.getElementById('activityChart').getContext('2d');
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: [{
                            label: 'Cerita Baru',
                            data: @json($storyCounts),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            tension: 0.3
                        },
                        {
                            label: 'Komentar Baru',
                            data: @json($commentCounts),
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            @role('admin')
            // Category Chart
            const categoryData = @json($categoryStats);
            const categoryLabels = categoryData.map(item => item.name);
            const categoryValues = categoryData.map(item => item.total);

            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryValues,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(199, 199, 199, 0.7)',
                        ],
                        borderWidth: 1
                    }]
                }
            });
            @endrole

            @role('user')
            // Monthly Activity Chart
            const monthlyCtx = document.getElementById('monthlyActivityChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [
                        {
                            label: 'Cerita',
                            data: @json($storyMonthly),
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Komentar',
                            data: @json($commentMonthly),
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Vote',
                            data: @json($voteMonthly),
                            backgroundColor: 'rgba(255, 206, 86, 0.7)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            @endrole
        });
    </script>
@endpush
