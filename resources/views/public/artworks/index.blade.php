<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">Discover Artworks</h1>
                <p class="text-gray-500 mb-8">Explore the best creativity from our community.</p>

                <form method="GET" action="{{ route('artworks.index') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
                    
                    <div class="relative w-full md:w-96">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search artworks or artists..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl text-sm font-medium">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <div class="flex flex-wrap gap-3 w-full md:w-auto">
                        <select name="category" onchange="this.form.submit()" class="bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl text-sm font-medium py-2.5 px-4 cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>

                        <select name="sort" onchange="this.form.submit()" class="bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl text-sm font-medium py-2.5 px-4 cursor-pointer">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>
                </form>
            </div>

            @if($artworks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($artworks as $artwork)
                        <div x-data="{ 
                                showReportModal: false, 
                                isLiked: {{ Auth::check() && Auth::user()->hasLiked($artwork) ? 'true' : 'false' }},
                                likeCount: {{ $artwork->likes_count }},
                                isFavorited: {{ Auth::check() && Auth::user()->hasFavorited($artwork) ? 'true' : 'false' }}
                                }" 
                                class="bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 group relative">
                            
                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
                                <a href="{{ route('artworks.show', $artwork) }}">
                                    <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                </a>
                                
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-start justify-end p-3 gap-2">
                                    
                                    @auth
                                        @if(Auth::id() !== $artwork->user_id)
                                            <button @click="showReportModal = true" class="bg-white/90 hover:bg-white text-gray-600 hover:text-red-500 p-2 rounded-lg backdrop-blur-sm transition" title="Report Artwork">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </button>
                                        @endif
                                    @else
                                        <div class="bg-white/50 text-gray-400 p-2 rounded-lg backdrop-blur-sm cursor-not-allowed" title="Login to report">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                    @endauth

                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-gray-900 truncate pr-2 w-full cursor-pointer hover:underline">
                                        <a href="{{ route('artworks.show', $artwork) }}">{{ $artwork->title }}</a>
                                    </h3>
                                </div>
                                
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                                        @if($artwork->user->profile_photo_path)
                                            <img src="{{ asset('storage/'.$artwork->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-black flex items-center justify-center text-[10px] text-white font-bold">
                                                {{ substr($artwork->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('member.show', $artwork->user->id) }}" class="text-xs text-gray-500 hover:text-black transition truncate">
                                        {{ $artwork->user->name }}
                                    </a>
                                </div>

                                <div class="flex items-center justify-between border-t border-gray-50 pt-3 mt-1">
                                    <div class="flex items-center gap-4">
                                        
                                        @auth
                                            <button @click="
                                                isLiked = !isLiked; 
                                                isLiked ? likeCount++ : likeCount--; 
                                                fetch('/artworks/' + {{ $artwork->id }} + '/like', { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'} });
                                            " class="flex items-center gap-1 group/btn focus:outline-none">
                                                <svg class="w-5 h-5 transition-colors duration-200" 
                                                        :class="isLiked ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/btn:text-red-500'" 
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                                <span class="text-xs font-medium text-gray-600" x-text="likeCount"></span>
                                            </button>
                                        @else
                                            <div class="flex items-center gap-1 cursor-not-allowed opacity-50" title="Login to like">
                                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                                <span class="text-xs font-medium text-gray-600">{{ $artwork->likes_count }}</span>
                                            </div>
                                        @endauth

                                        @auth
                                            <button @click="
                                                isFavorited = !isFavorited;
                                                fetch('/artworks/' + {{ $artwork->id }} + '/favorite', { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'} });
                                            " class="flex items-center gap-1 group/btn focus:outline-none">
                                                <svg class="w-5 h-5 transition-colors duration-200" 
                                                        :class="isFavorited ? 'text-yellow-500 fill-current' : 'text-gray-400 group-hover/btn:text-yellow-500'" 
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <div class="flex items-center gap-1 cursor-not-allowed opacity-50" title="Login to save">
                                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                            </div>
                                        @endauth

                                        @auth
                                            <a href="{{ route('artworks.show', $artwork) }}" class="flex items-center gap-1 group/btn">
                                                <svg class="w-5 h-5 text-gray-400 group-hover/btn:text-blue-500 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                <span class="text-xs font-medium text-gray-600">{{ $artwork->comments_count }}</span>
                                            </a>
                                        @else
                                            <div class="flex items-center gap-1 cursor-not-allowed opacity-50" title="Login to comment">
                                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                <span class="text-xs font-medium text-gray-600">{{ $artwork->comments_count }}</span>
                                            </div>
                                        @endauth

                                    </div>
                                </div>
                            </div>

                            @auth
                                <div x-show="showReportModal" style="display: none;" 
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                    <div @click.away="showReportModal = false" class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl transform transition-all">
                                        <h3 class="text-lg font-bold text-gray-900 mb-4">Report Artwork</h3>
                                        <p class="text-sm text-gray-500 mb-4">Why are you reporting "{{ $artwork->title }}"?</p>
                                        
                                        <form action="{{ route('artworks.report', $artwork->id) }}" method="POST">
                                            @csrf
                                            <div class="space-y-3 mb-4">
                                                <select name="reason" class="w-full bg-gray-50 border-transparent rounded-lg focus:border-black focus:ring-black text-sm">
                                                    <option value="Plagiarism">Plagiarism / Copyright</option>
                                                    <option value="Inappropriate">Inappropriate Content</option>
                                                    <option value="Spam">Spam or Misleading</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            
                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showReportModal = false" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-black">Cancel</button>
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 shadow-md">Submit Report</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endauth
                            </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $artworks->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No artworks found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your search or filters.</p>
                    <a href="{{ route('artworks.index') }}" class="inline-block mt-4 text-black font-medium underline">Clear filters</a>
                </div>
            @endif
        </div>
    </div>

    @auth
    <script>
        function toggleLike(artworkId) {
            fetch(`/artworks/${artworkId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                // Logic ini dihandle oleh AlpineJS state (:class dan x-text)
                // Kita hanya perlu me-reverse state di frontend secara manual
                // di dalam scope x-data jika tidak mau reload.
                // Namun, karena x-data scope tertutup, cara paling bersih di blade loop
                // adalah membiarkan x-data menghandle logic visualnya sendiri
                // dengan memanipulasi variabel 'isLiked' dan 'likeCount'.
            });

            // Update UI State via Alpine context (Hack untuk akses scope dari luar jika perlu, 
            // tapi disini kita pakai logic internal Alpine di @click button di atas)
            
            // NOTE: Logic update UI sesungguhnya ada di dalam x-data component:
            // @click="isLiked = !isLiked; isLiked ? likeCount++ : likeCount--; toggleLike({{ $artwork->id }})"
            // Saya update button di atas untuk merefleksikan ini.
        }

        function toggleFavorite(artworkId) {
             fetch(`/artworks/${artworkId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
        }
    </script>
    @endauth

    <button @click="
        isLiked = !isLiked; 
        isLiked ? likeCount++ : likeCount--; 
        fetch('/artworks/' + {{ $artwork->id }} + '/like', { 
            method: 'POST', 
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
    " class="flex items-center gap-1 group/btn focus:outline-none">
        <svg class="w-5 h-5 transition-colors duration-200" 
                :class="isLiked ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/btn:text-red-500'" 
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
        </svg>
        <span class="text-xs font-medium text-gray-600" x-text="likeCount"></span>
    </button>

    <button @click="
        isFavorited = !isFavorited;
        fetch('/artworks/' + {{ $artwork->id }} + '/favorite', { 
            method: 'POST', 
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
    " class="flex items-center gap-1 group/btn focus:outline-none">
        <svg class="w-5 h-5 transition-colors duration-200" 
                :class="isFavorited ? 'text-yellow-500 fill-current' : 'text-gray-400 group-hover/btn:text-yellow-500'" 
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
        </svg>
    </button>
    
    </x-app-layout>