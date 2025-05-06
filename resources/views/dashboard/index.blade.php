@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Statistik Platform </h3>
</div>
@role('admin')
    <!-- Original card stats -->
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

    <!-- Original charts row -->
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas 7 Hari Terakhir</h4>
                    <canvas id="activityChartAdmin" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Distribusi Kategori</h4>
                    <canvas id="categoryChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- NEW: Analytics for Global Reports -->
    <div class="page-header mt-4">
        <h3 class="page-title"> Laporan dan Analitik Global </h3>
    </div>

    <!-- NEW: Anonymous vs Non-Anonymous distribution -->
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Distribusi Posting Anonim vs Teridentifikasi</h4>
                    <canvas id="anonymityChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pertumbuhan & Aktivitas Pengguna</h4>
                    <canvas id="userGrowthChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- NEW: Interaction Trend and Anonymous Feature Usage -->
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tren Interaksi Pengguna (30 Hari Terakhir)</h4>
                    <canvas id="interactionTrendChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tren Penggunaan Fitur Anonim (6 Bulan Terakhir)</h4>
                    <canvas id="anonymousUsageTrendChart" style="height:250px"></canvas>
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
                    <canvas id="activityChartUser" style="height:250px"></canvas>
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
                            <div class="d-flex justify-content-between mb-3">
                                <span>Komen Diterima:</span>
                                <span class="badge badge-primary">{{ $commentReceived }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $upvotesReceived + $downvotesReceived + $commentReceived > 0 ? ($upvotesReceived / ($upvotesReceived + $downvotesReceived + $commentReceived) * 100) : 0 }}%"
                                    aria-valuenow="{{ $upvotesReceived }}" aria-valuemin="0"
                                    aria-valuemax="{{ $upvotesReceived + $downvotesReceived + $commentReceived }}">
                                    {{ $upvotesReceived + $downvotesReceived + $commentReceived > 0 ? round(($upvotesReceived / ($upvotesReceived + $downvotesReceived + $commentReceived) * 100), 1) : 0 }}%
                                </div>
                            </div>
                            <small class="text-muted">Rasio Upvote/Downvote/Komentar</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pola Partisipasi Bulanan (6 bulan terakhir)</h4>
                    <canvas id="monthlyActivityChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tren Interaksi Pengguna (30 Hari Terakhir)</h4>
                    <canvas id="interactionTrendChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>
@endrole

@role('moderator')
  <div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $pendingReports }}</h3>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Total Laporan Pending</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $spamComments }}</h3>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Total Komentar Spam</h6>
            </div>
        </div>
    </div>
</div>

  {{-- Grafik Laporan Harian --}}
  <div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Grafik Laporan Harian</h4>
                <canvas id="reportsChart" style="height:250px"></canvas>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @role('admin')
            const activityCtx = document.getElementById('activityChartAdmin').getContext('2d');
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

            // NEW: Anonymous vs Non-Anonymous Posts Chart
            const anonymityCtx = document.getElementById('anonymityChart').getContext('2d');
            new Chart(anonymityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Konten Anonim', 'Konten Bukan Anonim'],
                    datasets: [{
                        data: @json($anonymousData),
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(54, 162, 235, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // NEW: User Interaction Trend Chart
            const interactionCtx = document.getElementById('interactionTrendChart').getContext('2d');
            new Chart(interactionCtx, {
                type: 'line',
                data: {
                    labels: @json($interactionDates),
                    datasets: [{
                        label: 'Cerita',
                        data: @json($storyTrend),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Komentar',
                        data: @json($commentTrend),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Suara',
                        data: @json($voteTrend),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Interaksi'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });

            // NEW: Anonymous Feature Usage Trend Chart
            const anonymousTrendCtx = document.getElementById('anonymousUsageTrendChart').getContext('2d');
            new Chart(anonymousTrendCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: 'Cerita Anonim',
                        data: @json($anonymousStoryMonthly),
                        backgroundColor: 'rgba(153, 102, 255, 0.7)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Komentar Anonim',
                        data: @json($anonymousCommentMonthly),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah'
                            }
                        }
                    }
                }
            });

            // NEW: User Growth Chart
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(userGrowthCtx, {
                type: 'line',
                data: {
                    labels: @json($growthMonths),
                    datasets: [{
                        label: 'Pengguna Baru',
                        data: @json($newUserCounts),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Pengguna Aktif',
                        data: @json($activeUserCounts),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Pengguna'
                            }
                        }
                    }
                }
            });
            @endrole

            @role('user')
            const activityCtx = document.getElementById('activityChartUser').getContext('2d');
            const datasets = [
                {
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
            ];

            // Periksa ketersediaan variabel voteCounts sebelum menambahkannya ke dataset
            @if(isset($voteCounts) && count($voteCounts) > 0)
            datasets.push({
                label: 'Suara',
                data: @json($voteCounts),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2,
                tension: 0.3
            });
            @endif

            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Monthly Activity Chart
            const monthlyCtx = document.getElementById('monthlyActivityChart').getContext('2d');
            // Persiapkan dataset untuk monthly chart
            const monthlyDatasets = [
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
                }
            ];

            // Periksa ketersediaan variabel voteMonthly sebelum menambahkannya ke dataset
            @if(isset($voteMonthly) && count($voteMonthly) > 0)
            monthlyDatasets.push({
                label: 'Suara',
                data: @json($voteMonthly),
                backgroundColor: 'rgba(255, 206, 86, 0.7)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            });
            @endif

            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: monthlyDatasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const interactionCtx = document.getElementById('interactionTrendChart').getContext('2d');
            new Chart(interactionCtx, {
                type: 'line',
                data: {
                    labels: @json($interactionDates),
                    datasets: [{
                        label: 'Cerita',
                        data: @json($storyTrend),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Suara',
                        data: @json($voteTrend),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Interaksi'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });
            @endrole

            @role('moderator')
                const ctx = document.getElementById('reportsChart').getContext('2d');
                const reportsData = @json($reportsPerDay);
                new Chart(ctx, {
                type: 'line',
                data: {
                    labels: reportsData.map(r => r.date),
                    datasets: [{
                    label: 'Laporan per Hari',
                    data: reportsData.map(r => r.total),
                    fill: false,
                    borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                    x: { display: true },
                    y: { beginAtZero: true }
                    }
                }
                });
            @endrole
        });
    </script>
@endpush
