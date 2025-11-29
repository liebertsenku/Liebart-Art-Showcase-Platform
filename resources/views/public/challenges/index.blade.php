<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Creative Challenges</h1>
                <p class="text-gray-500 mt-2 max-w-2xl mx-auto">
                    Join specific themes, push your creative boundaries, and win recognition from curators.
                </p>
            </div>

            @if($challenges->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($challenges as $challenge)
                        <a href="{{ route('public.challenges.show', $challenge->slug) }}" class="group block h-full">
                            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 h-full flex flex-col">
                                
                                <!-- Cover Image -->
                                <div class="relative h-56 bg-gray-200 overflow-hidden">
                                    @if($challenge->banner_image)
                                        <img src="{{ asset('storage/' . $challenge->banner_image) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Status Badge -->
                                    <div class="absolute top-4 right-4">
                                        @php
                                            $status = $challenge->computed_status;
                                            $badgeColor = match($status) {
                                                'active' => 'bg-green-500 text-white',
                                                'upcoming' => 'bg-yellow-400 text-yellow-900',
                                                'ended' => 'bg-gray-800 text-white',
                                                default => 'bg-gray-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-bold uppercase rounded-full shadow-sm {{ $badgeColor }}">
                                            {{ $status }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition truncate" title="{{ $challenge->title }}">
                                        {{ $challenge->title }}
                                    </h3>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                                        {{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}
                                    </div>
                                    <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1">
                                        {{ $challenge->description }}
                                    </p>
                                    
                                    <!-- Footer -->
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-[10px] font-bold">
                                                {{ substr($challenge->curator->name ?? 'A', 0, 1) }}
                                            </div>
                                            <span class="text-xs text-gray-500">by {{ $challenge->curator->name ?? 'Admin' }}</span>
                                        </div>
                                        <span class="text-sm font-bold text-black group-hover:translate-x-1 transition">
                                            View Details &rarr;
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $challenges->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No challenges found</h3>
                    <p class="text-gray-500 mt-2">Check back later for new events.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
