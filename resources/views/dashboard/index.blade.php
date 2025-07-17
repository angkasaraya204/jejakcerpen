@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Statistik Platform </h3>
</div>
@role('admin')
    <!-- Original card stats -->
    <div class="row">
        <div class="col-md-6 mb-4">
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

        <div class="col-md-6 mb-4">
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
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
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
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $totalCategory }}</h3>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Kategori</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">Aktivitas User</h4>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm period-btn active" data-period="week">Minggu</button>
                            <button type="button" class="btn btn-outline-primary btn-sm period-btn" data-period="month">Bulan</button>
                            <button type="button" class="btn btn-outline-primary btn-sm period-btn" data-period="year">Tahun</button>
                        </div>
                    </div>
                    <canvas id="userActivityChart" style="height:300px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cerita yang User Baca per Kategori</h4>
                    <canvas id="userReadStoriesChart" style="height:300px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- NEW: Anonymous vs Non-Anonymous distribution -->
    <div class="row">
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Distribusi Posting Anonim vs Teridentifikasi</h4>
                    <canvas id="anonymityChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pertumbuhan & Aktivitas Pengguna</h4>
                    <canvas id="userGrowthChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Laporan dan Analitik --}}
    <div class="row">
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grafik Laporan Harian (30 Hari Terakhir)</h4>
                    <canvas id="reportsChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Distribusi Status Laporan</h4>
                    <canvas id="reportStatusChart" style="height:250px"></canvas>
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
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">Aktivitas Saya</h4>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm period-btn active" data-period="week">Minggu</button>
                            <button type="button" class="btn btn-outline-primary btn-sm period-btn" data-period="month">Bulan</button>
                            <button type="button" class="btn btn-outline-primary btn-sm period-btn" data-period="year">Tahun</button>
                        </div>
                    </div>
                    <canvas id="userActivityChart" style="height:300px"></canvas>
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
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cerita yang Saya Baca per Kategori</h4>
                    <canvas id="myReadStoriesChart" style="height:300px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Perbandingan dengan Semua Pengunjung</h4>
                    <canvas id="readComparisonChart" style="height:300px"></canvas>
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
                // Chart Distribusi Posting Anonim
                const anonymousData = @json($anonymousData);
                if (anonymousData && anonymousData.reduce((a, b) => a + b, 0) > 0) {
                    const anonymityCtx = document.getElementById('anonymityChart').getContext('2d');
                    new Chart(anonymityCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Konten Anonim', 'Konten Bukan Anonim'],
                            datasets: [{
                                data: anonymousData,
                                backgroundColor: [ 'rgba(153, 102, 255, 0.7)', 'rgba(54, 162, 235, 0.7)' ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                            const percentage = Math.round((context.raw / total) * 100);
                                            return `${context.label}: ${context.raw} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('anonymityChart').parentElement.innerHTML = '<div class="text-center text-muted py-5" style="height:250px; display:flex; align-items:center; justify-content:center;">Data tidak tersedia. <br>(Distribusi Posting Anonim vs Teridentifikasi)</div>';
                }

                // Chart Pertumbuhan & Aktivitas Pengguna
                const growthMonths = @json($growthMonths);
                const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
                new Chart(userGrowthCtx, {
                    type: 'line',
                    data: {
                        labels: growthMonths,
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
                                title: { display: true, text: 'Jumlah Pengguna' }
                            },
                            x: {
                                title: { display: true, text: 'Bulan' }
                            }
                        }
                    }
                });

                // Chart Cerita yang User Baca per Kategori
                const adminCategoryLabels = @json($categoryReadLabels ?? []);
                const adminCategoryCounts = @json($categoryReadCounts ?? []);
                if (adminCategoryLabels.length > 0) {
                    const userReadStoriesCtx = document.getElementById('userReadStoriesChart').getContext('2d');
                    new Chart(userReadStoriesCtx, {
                        type: 'doughnut',
                        data: {
                            labels: adminCategoryLabels,
                            datasets: [{
                                data: adminCategoryCounts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.8)','rgba(54, 162, 235, 0.8)','rgba(255, 206, 86, 0.8)',
                                    'rgba(75, 192, 192, 0.8)','rgba(153, 102, 255, 0.8)','rgba(255, 159, 64, 0.8)'
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                } else {
                    document.getElementById('userReadStoriesChart').parentElement.innerHTML = '<div class="text-center text-muted py-5" style="height:300px; display:flex; align-items:center; justify-content:center;">Data tidak tersedia. <br>(Cerita yang User Baca per Kategori)</div>';
                }

                // Chart Aktivitas User
                const adminActivityData = {
                    week: { labels: @json($weekLabels), stories: @json($weekStories), comments: @json($weekComments), votes: @json($weekVotes) },
                    month: { labels: @json($monthLabels), stories: @json($monthStories), comments: @json($monthComments), votes: @json($monthVotes) },
                    year: { labels: @json($yearLabels), stories: @json($yearStories), comments: @json($yearComments), votes: @json($yearVotes) }
                };
                const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
                let userActivityChart = new Chart(userActivityCtx, {
                    type: 'line',
                    data: {
                        labels: adminActivityData.week.labels,
                        datasets: [
                            { label: 'Cerita', data: adminActivityData.week.stories, backgroundColor: 'rgba(54, 162, 235, 0.2)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 2, tension: 0.3, fill: true },
                            { label: 'Komentar', data: adminActivityData.week.comments, backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 2, tension: 0.3, fill: true },
                            { label: 'Voting', data: adminActivityData.week.votes, backgroundColor: 'rgba(255, 206, 86, 0.2)', borderColor: 'rgba(255, 206, 86, 1)', borderWidth: 2, tension: 0.3, fill: true }
                        ]
                    },
                    options: {
                        responsive: true, layout: { padding: { top: 20, bottom: 20, left: 20, right: 20 } },
                        plugins: {
                            legend: { display: true, position: 'top' },
                            tooltip: { mode: 'index', intersect: false, callbacks: {
                                title: function(context) { return 'Tanggal: ' + context[0].label; },
                                label: function(context) { return context.dataset.label + ': ' + context.parsed.y + ' aktivitas'; }
                            }}
                        },
                        scales: {
                            y: { beginAtZero: true, display: true, title: { display: true, text: 'Jumlah Aktivitas', font: { size: 14, weight: 'bold' }}, ticks: { display: true, stepSize: 1, font: { size: 12 }, callback: function(value) { return Number.isInteger(value) ? value : ''; }}, grid: { display: true }},
                            x: { display: true, title: { display: true, text: 'Periode Waktu', font: { size: 14, weight: 'bold' }}, ticks: { display: true, maxRotation: 45, minRotation: 0, font: { size: 11 }}, grid: { display: true }}
                        },
                        interaction: { mode: 'nearest', axis: 'x', intersect: false }
                    }
                });
                document.querySelectorAll('.period-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const period = this.dataset.period;
                        document.querySelectorAll('.period-btn').forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                        userActivityChart.data.labels = adminActivityData[period].labels;
                        userActivityChart.data.datasets[0].data = adminActivityData[period].stories;
                        userActivityChart.data.datasets[1].data = adminActivityData[period].comments;
                        userActivityChart.data.datasets[2].data = adminActivityData[period].votes;
                        userActivityChart.update();
                    });
                });

                const style = document.createElement('style');
                style.textContent = `.period-btn.active { background-color: #007bff !important; color: white !important; border-color: #007bff !important; } .period-btn:hover { background-color: #0056b3 !important; color: white !important; border-color: #0056b3 !important; }`;
                document.head.appendChild(style);

                // Chart Laporan Harian
                const reportsData = @json($reportsPerDay);
                if (reportsData && reportsData.length > 0) {
                    const ctx = document.getElementById('reportsChart').getContext('2d');
                    const dates = reportsData.map(r => new Date(r.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short' }));
                    const totals = reportsData.map(r => r.total);
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [{ label: 'Total Laporan per Hari', data: totals, backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 2, fill: true, tension: 0.3 }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: { display: true, title: { display: true, text: 'Tanggal' } },
                                y: { beginAtZero: true, title: { display: true, text: 'Jumlah Laporan' } }
                            }
                        }
                    });
                } else {
                    document.getElementById('reportsChart').parentElement.innerHTML = '<div class="text-center text-muted py-5" style="height:250px; display:flex; align-items:center; justify-content:center;">Data tidak tersedia. <a href="/reports">Lihat laporan lainnya.</a></div>';
                }

                // Chart Distribusi Status Laporan
                const reportStatusData = [
                    {{ $storyReportsPending + $commentReportsPending }},
                    {{ $storyReportsValid + $commentReportsValid }},
                    {{ $storyReportsInvalid + $commentReportsInvalid }}
                ];
                if(reportStatusData.reduce((a, b) => a + b, 0) > 0) {
                    const statusCtx = document.getElementById('reportStatusChart').getContext('2d');
                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Pending', 'Valid', 'Tidak Valid'],
                            datasets: [{
                                data: reportStatusData,
                                backgroundColor: [ 'rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(255, 99, 132, 0.8)' ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                } else {
                     document.getElementById('reportStatusChart').parentElement.innerHTML = '<div class="text-center text-muted py-5" style="height:250px; display:flex; align-items:center; justify-content:center;">Data tidak tersedia. <a href="/reports">Lihat laporan lainnya.</a></div>';
                }
            @endrole

            @role('user')
                const categoryLabels = @json($categoryReadLabels ?? []);
                const categoryCounts = @json($categoryReadCounts ?? []);
                const visitorCounts = @json($visitorStoriesPerCategory->pluck('total_views')->toArray() ?? []);

                // Chart Cerita yang Dibaca per Kategori
                if (categoryLabels.length > 0) {
                    const myReadStoriesCtx = document.getElementById('myReadStoriesChart').getContext('2d');
                    new Chart(myReadStoriesCtx, {
                        type: 'doughnut',
                        data: {
                            labels: categoryLabels,
                            datasets: [{
                                data: categoryCounts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.8)','rgba(54, 162, 235, 0.8)','rgba(255, 206, 86, 0.8)',
                                    'rgba(75, 192, 192, 0.8)','rgba(153, 102, 255, 0.8)','rgba(255, 159, 64, 0.8)'
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                } else {
                    document.getElementById('myReadStoriesChart').parentElement.innerHTML = '<div class="text-center text-muted py-5" style="height:300px; display:flex; align-items:center; justify-content:center;">Data tidak tersedia. <br>(Cerita yang User Baca per Kategori)</div>';
                }

                // Chart Perbandingan dengan Semua Pengunjung
                if (categoryLabels.length > 0) {
                    const readComparisonCtx = document.getElementById('readComparisonChart').getContext('2d');
                    new Chart(readComparisonCtx, {
                        type: 'bar',
                        data: {
                            labels: categoryLabels,
                            datasets: [{
                                label: 'Saya Baca',
                                data: categoryCounts,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }, {
                                label: 'Semua Pengunjung',
                                data: visitorCounts,
                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                borderColor: 'rgba(255, 99, 132, 1)',
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
                                        text: 'Jumlah Cerita Dibaca'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Kategori'
                                    }
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('readComparisonChart').parentElement.innerHTML = '<div class="text-center text-muted py-5" style="height:300px; display:flex; align-items:center; justify-content:center;">Data tidak tersedia. <br>(Perbandingan dengan Semua Pengunjung)</div>';
                }

                // Chart Aktivitas Saya
                const userActivityData = {
                    week: { labels: @json($weekLabels), stories: @json($weekStories), comments: @json($weekComments), votes: @json($weekVotes) },
                    month: { labels: @json($monthLabels), stories: @json($monthStories), comments: @json($monthComments), votes: @json($monthVotes) },
                    year: { labels: @json($yearLabels), stories: @json($yearStories), comments: @json($yearComments), votes: @json($yearVotes) }
                };
                const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
                let userActivityChart = new Chart(userActivityCtx, {
                    type: 'line',
                    data: {
                        labels: userActivityData.week.labels,
                        datasets: [
                            { label: 'Cerita', data: userActivityData.week.stories, backgroundColor: 'rgba(54, 162, 235, 0.2)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 2, tension: 0.3, fill: true },
                            { label: 'Komentar', data: userActivityData.week.comments, backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 2, tension: 0.3, fill: true },
                            { label: 'Voting', data: userActivityData.week.votes, backgroundColor: 'rgba(255, 206, 86, 0.2)', borderColor: 'rgba(255, 206, 86, 1)', borderWidth: 2, tension: 0.3, fill: true }
                        ]
                    },
                    options: {
                        responsive: true, layout: { padding: { top: 20, bottom: 20, left: 20, right: 20 } },
                        plugins: {
                            legend: { display: true, position: 'top' },
                            tooltip: { mode: 'index', intersect: false, callbacks: {
                                title: function(context) { return 'Tanggal: ' + context[0].label; },
                                label: function(context) { return context.dataset.label + ': ' + context.parsed.y + ' aktivitas'; }
                            }}
                        },
                        scales: {
                            y: { beginAtZero: true, display: true, title: { display: true, text: 'Jumlah Aktivitas', font: { size: 14, weight: 'bold' }}, ticks: { display: true, stepSize: 1, font: { size: 12 }, callback: function(value) { return Number.isInteger(value) ? value : ''; }}, grid: { display: true }},
                            x: { display: true, title: { display: true, text: 'Periode Waktu', font: { size: 14, weight: 'bold' }}, ticks: { display: true, maxRotation: 45, minRotation: 0, font: { size: 11 }}, grid: { display: true }}
                        },
                        interaction: { mode: 'nearest', axis: 'x', intersect: false }
                    }
                });
                document.querySelectorAll('.period-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const period = this.dataset.period;
                        document.querySelectorAll('.period-btn').forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                        userActivityChart.data.labels = userActivityData[period].labels;
                        userActivityChart.data.datasets[0].data = userActivityData[period].stories;
                        userActivityChart.data.datasets[1].data = userActivityData[period].comments;
                        userActivityChart.data.datasets[2].data = userActivityData[period].votes;
                        userActivityChart.update();
                    });
                });

                const style = document.createElement('style');
                style.textContent = `.period-btn.active { background-color: #007bff !important; color: white !important; border-color: #007bff !important; } .period-btn:hover { background-color: #0056b3 !important; color: white !important; border-color: #0056b3 !important; }`;
                document.head.appendChild(style);
            @endrole
        });
    </script>
@endpush
