<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">Discover Artworks</h1>
                <p class="text-gray-500 mb-6">Explore the best creativity from our community.</p>

                <div class="bg-black rounded-2xl p-6 md:p-8 mb-8 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -ml-16 -mb-16"></div>
                    
                    <div class="relative z-10 text-center md:text-left">
                        <span class="inline-block px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold uppercase tracking-wider rounded-full mb-2">Happening Now</span>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-1">Join Creative Challenges</h2>
                        <p class="text-gray-400 text-sm md:text-base max-w-lg">Push your limits, compete with others, and win recognition from curators.</p>
                    </div>
                    
                    <div class="relative z-10 flex-shrink-0">
                        <a href="{{ route('public.challenges.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-black font-bold rounded-xl hover:bg-gray-100 transition transform hover:scale-105">
                            View Challenges &rarr;
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('artworks.index') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="relative w-full md:w-96">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search artworks or stories..." 
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
                                liked: {{ Auth::check() && Auth::user()->hasLiked($artwork) ? 'true' : 'false' }},
                                likeCount: {{ $artwork->likes_count }},
                                isFavorited: {{ Auth::check() && Auth::user()->hasFavorited($artwork) ? 'true' : 'false' }},
                                loading: false, // State loading agar tidak double click
                                
                                async toggleLike() {
                                    if (this.loading) return;
                                    this.loading = true;
                                    
                                    // Optimistic Update
                                    this.liked = !this.liked;
                                    this.likeCount = this.liked ? this.likeCount + 1 : this.likeCount - 1;

                                    try {
                                        const response = await fetch('/artworks/{{ $artwork->id }}/like', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        });
                                        const data = await response.json();
                                        if (data.status === 'success') {
                                            this.liked = data.liked; 
                                            this.likeCount = data.count;
                                        }
                                    } catch (error) {
                                        this.liked = !this.liked; // Rollback
                                        this.likeCount = this.liked ? this.likeCount + 1 : this.likeCount - 1;
                                    } finally {
                                        this.loading = false;
                                    }
                                },

                                async toggleFavorite() {
                                    this.isFavorited = !this.isFavorited;
                                    fetch('/artworks/{{ $artwork->id }}/favorite', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                }
                             }" 
                             class="bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 group relative flex flex-col h-full">
                            
                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden group/media">
                                <a href="{{ route('artworks.show', $artwork) }}" class="block w-full h-full">
                                    @if($artwork->image)
                                        <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover transform group-hover/media:scale-105 transition duration-700">
                                    @else
                                        <div class="w-full h-full p-6 flex flex-col justify-center items-center text-center bg-white border-b border-gray-50">
                                            <span class="text-4xl text-gray-200 mb-2 font-serif">❝</span>
                                            <p class="text-gray-800 font-serif text-sm leading-relaxed line-clamp-4 italic">
                                                {{ $artwork->description }}
                                            </p>
                                            <span class="mt-auto text-[10px] uppercase tracking-widest text-gray-400 font-bold pt-4">Written Piece</span>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/media:opacity-100 transition-opacity duration-300 flex items-start justify-end p-3 gap-2">
                                    @auth
                                        @if(Auth::id() !== $artwork->user_id)
                                            <button @click="showReportModal = true" class="bg-white/90 hover:bg-white text-gray-600 hover:text-red-500 p-2 rounded-lg backdrop-blur-sm transition" title="Report">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <div class="mb-2">
                                    <h3 class="font-bold text-gray-900 truncate pr-2 w-full cursor-pointer hover:underline">
                                        <a href="{{ route('artworks.show', $artwork) }}">{{ $artwork->title }}</a>
                                    </h3>
                                </div>
                                
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                                        @if($artwork->user->profile_photo_path)
                                            <img src="{{ asset('storage/'.$artwork->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-black flex items-center justify-center text-[10px] text-white font-bold">{{ substr($artwork->user->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <a href="{{ route('member.show', $artwork->user->id) }}" class="text-xs text-gray-500 hover:text-black transition truncate">
                                        {{ $artwork->user->name }}
                                    </a>
                                </div>

                                <div class="flex items-center justify-between border-t border-gray-50 pt-3 mt-auto">
                                    <div class="flex items-center gap-4">
                                        
                                        @auth
                                            <button @click="toggleLike()" 
                                                    class="flex items-center gap-1 group/btn focus:outline-none transition transform active:scale-95"
                                                    :class="{ 'opacity-50 cursor-wait': loading }"
                                                    :disabled="loading">
                                                <svg class="w-5 h-5 transition-colors duration-200" 
                                                     :class="liked ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/btn:text-red-500'" 
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                                <span class="text-xs font-medium text-gray-600" x-text="likeCount"></span>
                                            </button>
                                        @else
                                            <div class="flex items-center gap-1 cursor-not-allowed opacity-50" title="Login to like">
                                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                                <span class="text-xs font-medium text-gray-600">{{ $artwork->likes_count }}</span>
                                            </div>
                                        @endauth

                                        @auth
                                            <button @click="toggleFavorite()" class="flex items-center gap-1 group/btn focus:outline-none">
                                                <svg class="w-5 h-5 transition-colors duration-200" 
                                                     :class="isFavorited ? 'text-yellow-500 fill-current' : 'text-gray-400 group-hover/btn:text-yellow-500'" 
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                            </button>
                                        @else
                                             <div class="flex items-center gap-1 cursor-not-allowed opacity-50" title="Login to save">
                                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                            </div>
                                        @endauth

                                        @auth
                                            <a href="{{ route('artworks.show', $artwork) }}" class="flex items-center gap-1 group/btn">
                                                 <svg class="w-5 h-5 text-gray-400 group-hover/btn:text-blue-500 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                 <span class="text-xs font-medium text-gray-600">{{ $artwork->comments_count }}</span>
                                            </a>
                                        @else
                                            <div class="flex items-center gap-1 cursor-not-allowed opacity-50" title="Login to comment">
                                                 <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
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
</x-app-layout>