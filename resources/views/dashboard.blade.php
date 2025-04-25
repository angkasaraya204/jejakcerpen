<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @role('admin')
                    <h3 class="text-lg font-semibold mb-4">Statistik Platform</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $totalStories }}</div>
                            <div class="text-gray-600">Total Cerita</div>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $pendingStories }}</div>
                            <div class="text-gray-600">Cerita Menunggu</div>
                        </div>
                        <div class="bg-green-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $approvedStories }}</div>
                            <div class="text-gray-600">Cerita Dipublikasi</div>
                        </div>
                        <div class="bg-red-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $rejectedStories }}</div>
                            <div class="text-gray-600">Cerita Ditolak</div>
                        </div>
                        <div class="bg-purple-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $totalUsers }}</div>
                            <div class="text-gray-600">Total Pengguna</div>
                        </div>
                        <div class="bg-indigo-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $totalComments }}</div>
                            <div class="text-gray-600">Total Komentar</div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Aktivitas 7 Hari Terakhir</h3>
                        <canvas id="activityChart" width="400" height="200"></canvas>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Distribusi Kategori</h3>
                        <canvas id="categoryChart" width="400" height="200"></canvas>
                    </div>
                    @endrole

                    @role('user')
                    <h3 class="text-lg font-semibold mb-4">Statistik Platform</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $totalStories }}</div>
                            <div class="text-gray-600">Total Cerita</div>
                        </div>
                        <div class="bg-indigo-100 p-4 rounded shadow">
                            <div class="text-xl font-bold">{{ $totalComments }}</div>
                            <div class="text-gray-600">Total Komentar</div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Aktivitas 7 Hari Terakhir</h3>
                        <canvas id="activityChart" width="400" height="200"></canvas>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activity Chart
            const activityCtx = document.getElementById('activityChart').getContext('2d');
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: [
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
        });
    </script>
    @endpush
</x-app-layout>
