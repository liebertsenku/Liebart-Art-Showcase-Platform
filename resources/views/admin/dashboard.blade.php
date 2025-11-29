<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Platform Overview</h1>

            <!-- 1. STATS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- User Stat -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Total Users</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</div>
                </div>
                <!-- Artwork Stat -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Total Artworks</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_artworks'] }}</div>
                </div>
                <!-- Challenge Submissions -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Challenge Submissions</div>
                    <div class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['total_submissions'] }}</div>
                </div>
                <!-- Pending Reports -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium">Pending Reports</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">{{ $stats['reports_pending'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- 2. MAIN MENU GRID (Left Column) -->
                <div class="lg:col-span-2">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Management Modules</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- CARD: CURATOR APPROVAL (YANG BARU DITAMBAHKAN) -->
                        <a href="{{ route('admin.curators.index') }}" class="group bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 hover:shadow-md hover:border-yellow-200 transition duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 bg-yellow-50 w-20 h-20 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-yellow-600 group-hover:text-white transition duration-300">
                                        ✨
                                    </div>
                                    @if($stats['curators_pending'] > 0)
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">
                                            {{ $stats['curators_pending'] }} Pending
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:translate-x-1 transition duration-300">Curator Requests</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    Review applications for new curators.
                                </p>
                            </div>
                        </a>

                        <!-- CARD: USER MANAGEMENT -->
                        <a href="{{ route('admin.users.index') }}" class="group bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 bg-blue-50 w-20 h-20 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-xl group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                                    👥
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:translate-x-1 transition duration-300">User Management</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    Manage members and admins.
                                </p>
                            </div>
                        </a>

                        <!-- CARD: MODERATION -->
                        <a href="{{ route('admin.moderation.index') }}" class="group bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 hover:shadow-md hover:border-red-200 transition duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 bg-red-50 w-20 h-20 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mb-4 text-xl group-hover:bg-red-600 group-hover:text-white transition duration-300">
                                    🛡️
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:translate-x-1 transition duration-300">Moderation</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    Handle reported content.
                                </p>
                            </div>
                        </a>

                        <!-- CARD: CATEGORIES -->
                        <a href="{{ route('admin.categories.index') }}" class="group bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 bg-green-50 w-20 h-20 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4 text-xl group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                    🏷️
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:translate-x-1 transition duration-300">Categories</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    Organize artwork tags.
                                </p>
                            </div>
                        </a>

                        <!-- CARD: CHALLENGES -->
                        <a href="{{ route('admin.challenges.index') }}" class="group bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 bg-purple-50 w-20 h-20 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 text-xl group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                                    🏆
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:translate-x-1 transition duration-300">Challenges</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    Monitor community events.
                                </p>
                            </div>
                        </a>

                    </div>

                    <!-- Chart Section -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Artworks per Category</h3>
                        <div class="h-64 w-full">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- 3. SIDEBAR STATS (Right Column) -->
                <div class="space-y-8">
                    
                    <!-- Quick Links Sidebar -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            
                            <!-- LINK BARU: CURATOR APPROVAL -->
                            <a href="{{ route('admin.curators.index') }}" class="block p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition flex justify-between items-center">
                                <span class="text-yellow-800 font-medium">Curator Approvals</span>
                                @if($stats['curators_pending'] > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $stats['curators_pending'] }} New</span>
                                @else
                                    <span class="text-yellow-600">&rarr;</span>
                                @endif
                            </a>

                            <a href="{{ route('admin.users.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>User Management</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('admin.moderation.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>Moderation Queue</span>
                                <span class="text-red-500 font-bold">{{ $stats['reports_pending'] }}</span>
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex justify-between">
                                <span>Manage Categories</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Top Creator -->
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

                    <!-- Top Artwork -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Most Popular</h3>
                        @if($topArtwork)
                            <div class="flex gap-4">
                                <img src="{{ asset('storage/'.$topArtwork->image) }}" class="w-20 h-20 object-cover rounded-lg">
                                <div>
                                    <div class="font-bold text-gray-900 text-sm line-clamp-1">{{ $topArtwork->title }}</div>
                                    <div class="text-xs text-gray-500 mb-2">by {{ $topArtwork->user->name }}</div>
                                    <div class="flex items-center text-red-500 font-bold text-sm">
                                        <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                        {{ $topArtwork->likes_count }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
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