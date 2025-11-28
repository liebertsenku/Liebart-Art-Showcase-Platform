<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Platform Overview</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Total Users</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Total Artworks</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_artworks'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Challenge Submissions</div>
                    <div class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['total_submissions'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Pending Reports</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">{{ $stats['reports_pending'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Most Popular Artwork</h3>
                        @if($topArtwork)
                            <div class="flex gap-4">
                                <img src="{{ asset('storage/'.$topArtwork->image) }}" class="w-24 h-24 object-cover rounded-lg">
                                <div>
                                    <div class="font-bold text-xl">{{ $topArtwork->title }}</div>
                                    <div class="text-gray-500">by {{ $topArtwork->user->name }}</div>
                                    <div class="mt-2 flex items-center text-red-500 font-bold">
                                        <svg class="w-5 h-5 mr-1 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                        {{ $topArtwork->likes_count }} Likes
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-400">No data yet.</p>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Artworks per Category</h3>
                        <div class="h-64 w-full">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Top Creator</h3>
                        @if($topCreator)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-black text-white rounded-full flex items-center justify-center text-xl font-bold">
                                    {{ substr($topCreator->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-lg">{{ $topCreator->name }}</div>
                                    <div class="text-gray-500">{{ $topCreator->artworks_count }} Artworks</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Links</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>User Management</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>Manage Categories</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('admin.challenges.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>Manage Challenges</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('admin.moderation.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>Moderation Queue</span>
                                <span class="text-red-500 font-bold">{{ $stats['reports_pending'] }}</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: '# of Artworks',
                    data: {!! json_encode($chartData['data']) !!},
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>