<x-app-layout>
    <div class="relative bg-black text-white">
        @if($challenge->banner_image)
            <div class="absolute inset-0 opacity-40">
                <img src="{{ asset('storage/' . $challenge->banner_image) }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            @php
                $status = $challenge->computed_status;
                $badgeColor = match($status) {
                    'active' => 'bg-green-500 text-white',
                    'upcoming' => 'bg-yellow-400 text-yellow-900',
                    'ended' => 'bg-gray-800 text-white',
                    default => 'bg-gray-200'
                };
            @endphp
            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-white/30">
                Status: {{ $status }}
            </span>

            <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">{{ $challenge->title }}</h1>
            
            <div class="flex flex-wrap items-center gap-6 text-gray-300 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Curator: {{ $challenge->curator->name ?? 'Official' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#F5F4F2] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-2 space-y-10">
                    
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">About Challenge</h3>
                        <div class="prose prose-gray max-w-none">
                            <p class="whitespace-pre-line text-gray-600 leading-relaxed">{{ $challenge->description }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <span class="bg-red-100 text-red-600 p-2 rounded-lg text-lg">📜</span> Rules
                            </h3>
                            <p class="text-gray-600 text-sm whitespace-pre-line">{{ $challenge->rules }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg text-lg">🎁</span> Prizes
                            </h3>
                            <p class="text-gray-600 text-sm whitespace-pre-line">{{ $challenge->prizes ?? 'Glory and Recognition.' }}</p>
                        </div>
                    </div>

                    @if($challenge->computed_status == 'ended' && $challenge->winners->isNotEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-yellow-200 rounded-full opacity-50 blur-2xl"></div>
                            <h2 class="text-3xl font-bold text-yellow-900 mb-8 text-center relative z-10">🏆 Hall of Fame</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                                @foreach($challenge->winners as $winner)
                                    <div class="bg-white/80 backdrop-blur p-4 rounded-2xl text-center border border-white/50 shadow-sm {{ $winner->position == 1 ? 'transform md:-translate-y-4 md:scale-105 z-20 border-yellow-400 border-2' : '' }}">
                                        <div class="inline-block w-10 h-10 rounded-full bg-yellow-400 text-yellow-900 font-bold text-xl flex items-center justify-center mb-3 mx-auto shadow-lg">
                                            {{ $winner->position }}
                                        </div>
                                        <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-gray-200 flex items-center justify-center">
                                            @if($winner->submission->artwork->image)
                                                <img src="{{ asset('storage/'.$winner->submission->artwork->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-4xl">📝</span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-gray-900 truncate">{{ $winner->submission->artwork->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $winner->submission->user->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Submissions ({{ $submissions->total() }})</h3>
                        
                        @if($submissions->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($submissions as $sub)
                                    <a href="{{ route('artworks.show', $sub->artwork->id) }}" class="group block relative aspect-square bg-gray-200 rounded-xl overflow-hidden border border-gray-200">
                                        @if($sub->artwork->image)
                                            <img src="{{ asset('storage/'.$sub->artwork->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-white group-hover:bg-gray-50 transition">
                                                <span class="text-2xl text-gray-300 font-serif mb-2">❝</span>
                                                <p class="text-xs text-gray-600 font-serif line-clamp-3 italic">{{ $sub->artwork->description }}</p>
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                                        
                                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                                            <p class="text-white text-xs font-bold truncate">{{ $sub->artwork->title }}</p>
                                            <p class="text-gray-300 text-[10px]">{{ $sub->user->name }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                {{ $submissions->links() }}
                            </div>
                        @else
                            <div class="text-center py-12 bg-white rounded-3xl border border-gray-100 border-dashed">
                                <p class="text-gray-500">No submissions yet. Be the first!</p>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        
                        @guest
                            <div class="bg-black text-white rounded-3xl p-8 text-center shadow-xl">
                                <h3 class="text-xl font-bold mb-2">Join this Challenge</h3>
                                <p class="text-gray-400 text-sm mb-6">Login or register to submit your artwork and compete with others.</p>
                                <a href="{{ route('login') }}" class="block w-full bg-white text-black font-bold py-3 rounded-xl hover:bg-gray-100 transition">
                                    Login to Submit
                                </a>
                            </div>
                        @endguest

                        @auth
                            @if($hasSubmitted)
                                <div class="bg-green-50 border border-green-200 rounded-3xl p-6 text-center">
                                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                        ✓
                                    </div>
                                    <h3 class="text-lg font-bold text-green-900">Submission Received!</h3>
                                    <p class="text-green-700 text-sm mb-4">You have joined this challenge.</p>
                                    
                                    <div class="bg-white p-3 rounded-xl shadow-sm border border-green-100 mb-4 text-left flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                            @if($mySubmission->artwork->image)
                                                <img src="{{ asset('storage/'.$mySubmission->artwork->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-lg">📝</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-sm text-gray-900 truncate">{{ $mySubmission->artwork->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $mySubmission->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>

                                    @if($challenge->computed_status !== 'ended')
                                        <form action="{{ route('challenges.submission.destroy', $mySubmission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw your submission?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 text-xs font-bold underline hover:text-red-700 transition focus:outline-none">
                                                Withdraw Submission
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            
                            @elseif($challenge->computed_status == 'active')
                                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4">Submit Your Work</h3>
                                    
                                    @if($myArtworks->isEmpty())
                                        <div class="text-center py-6">
                                            <p class="text-sm text-gray-500 mb-4">You don't have any artwork uploaded yet.</p>
                                            <a href="{{ route('member.artworks.create') }}" class="block w-full bg-gray-100 text-gray-900 font-bold py-3 rounded-xl hover:bg-gray-200 transition text-center">
                                                Upload Artwork First
                                            </a>
                                        </div>
                                    @else
                                        <form action="{{ route('challenges.submit', $challenge->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Select from your gallery:</label>
                                                
                                                <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                                    @foreach($myArtworks as $art)
                                                        <label class="cursor-pointer block relative group">
                                                            <input type="radio" name="artwork_id" value="{{ $art->id }}" class="peer sr-only" required>
                                                            
                                                            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl transition 
                                                                        hover:border-gray-400 
                                                                        peer-checked:border-black peer-checked:ring-1 peer-checked:ring-black peer-checked:bg-gray-50">
                                                                
                                                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                                                    @if($art->image)
                                                                        <img src="{{ asset('storage/'.$art->image) }}" class="w-full h-full object-cover">
                                                                    @else
                                                                        <span class="text-lg">📝</span>
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="flex-1 min-w-0">
                                                                    <div class="text-sm font-bold text-gray-900 truncate">{{ $art->title }}</div>
                                                                </div>
                                                                
                                                                <div class="hidden peer-checked:block text-black">
                                                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <button type="submit" class="block w-full bg-black text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-lg">
                                                Submit Selected Artwork
                                            </button>
                                        </form>
                                    @endif
                                </div>

                            @else
                                <div class="bg-gray-100 rounded-3xl p-8 text-center">
                                    <h3 class="text-xl font-bold text-gray-400 mb-2">Challenge Ended</h3>
                                    <p class="text-gray-500 text-sm">Submissions are closed for this event.</p>
                                </div>
                            @endif
                        @endauth

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>