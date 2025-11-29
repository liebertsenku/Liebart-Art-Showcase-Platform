<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-start mb-8">
                <div>
                    <a href="{{ route('curator.challenges.index') }}" class="text-gray-500 hover:text-black mb-2 inline-block">&larr; Back to Challenges</a>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $challenge->title }}</h1>
                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                        @php
                            $statusColors = [
                                'active' => 'bg-green-100 text-green-800',
                                'upcoming' => 'bg-yellow-100 text-yellow-800',
                                'ended' => 'bg-gray-800 text-white',
                                'draft' => 'bg-gray-200 text-gray-600',
                            ];
                            $statusColor = $statusColors[$challenge->computed_status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-xs rounded-full font-bold uppercase {{ $statusColor }}">
                            {{ $challenge->computed_status }}
                        </span>
                        <span>{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    
                    @if($challenge->computed_status !== 'ended')
                        <form action="{{ route('curator.challenges.finish', $challenge->id) }}" method="POST" onsubmit="return confirm('Finish this challenge? \n\nThis will CLOSE submissions and PUBLISH the winners to everyone. This action cannot be undone.');">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-green-700 transition flex items-center gap-2 shadow-lg shadow-green-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Finish & Publish Winners
                            </button>
                        </form>
                    @else
                        <span class="px-4 py-2 bg-gray-100 text-gray-500 rounded-lg font-bold text-sm border border-gray-200 cursor-not-allowed">
                            Challenge Ended
                        </span>
                    @endif

                    <a href="{{ route('curator.challenges.edit', $challenge->id) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-50 transition">
                        Edit
                    </a>
                    
                    <form action="{{ route('curator.challenges.destroy', $challenge->id) }}" method="POST" onsubmit="return confirm('Delete this challenge? This action cannot be undone.');">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-700 transition">Delete</button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-yellow-200 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 rounded-full blur-2xl -mr-16 -mt-16"></div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-4 relative z-10 flex items-center gap-2">
                            <span>🏆</span> Winners Podium
                        </h3>
                        
                        <div class="space-y-4 relative z-10">
                            @foreach([1, 2, 3] as $pos)
                                <div class="flex items-center gap-3 p-3 rounded-xl border transition-all duration-300 
                                    {{ isset($winners[$pos]) ? 'border-yellow-400 bg-yellow-50 shadow-sm' : 'border-gray-100 bg-gray-50 border-dashed' }}">
                                    
                                    <div class="w-8 h-8 flex-shrink-0 rounded-full flex items-center justify-center font-bold text-sm
                                        {{ $pos == 1 ? 'bg-yellow-400 text-yellow-900' : ($pos == 2 ? 'bg-gray-300 text-gray-800' : 'bg-orange-300 text-orange-900') }}">
                                        #{{ $pos }}
                                    </div>

                                    @if(isset($winners[$pos]))
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-bold text-gray-900 truncate">{{ $winners[$pos]->submission->artwork->title }}</div>
                                            <div class="text-xs text-gray-500 truncate">by {{ $winners[$pos]->submission->user->name }}</div>
                                        </div>
                                        <img src="{{ asset('storage/' . $winners[$pos]->submission->artwork->image) }}" class="w-10 h-10 rounded-lg object-cover bg-gray-200 border border-white shadow-sm">
                                        
                                        <form action="{{ route('curator.challenges.remove_winner', ['challenge' => $challenge->id, 'position' => $pos]) }}" method="POST" onsubmit="return confirm('Remove this winner?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 ml-2 p-1 hover:bg-red-50 rounded-full transition" title="Remove Winner">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex-1 text-xs text-gray-400 italic">Empty Spot</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-2 text-sm uppercase tracking-wide text-gray-400">Description</h4>
                        <p class="text-sm text-gray-600 mb-6 whitespace-pre-line leading-relaxed">{{ $challenge->description }}</p>
                        
                        <h4 class="font-bold text-gray-900 mb-2 text-sm uppercase tracking-wide text-gray-400">Rules</h4>
                        <p class="text-sm text-gray-600 mb-6 whitespace-pre-line leading-relaxed">{{ $challenge->rules }}</p>

                        <h4 class="font-bold text-gray-900 mb-2 text-sm uppercase tracking-wide text-gray-400">Prizes</h4>
                        <p class="text-sm text-gray-600 whitespace-pre-line leading-relaxed">{{ $challenge->prizes ?? 'No prizes listed.' }}</p>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Submissions ({{ $submissions->total() }})</h2>
                    </div>

                    @if($submissions->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($submissions as $sub)
                                <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm group relative">
                                    
                                    <div class="relative h-56 bg-gray-200">
                                        <img src="{{ asset('storage/' . $sub->artwork->image) }}" class="w-full h-full object-cover">
                                        
                                        @if(Auth::id() === $challenge->curator_id)
                                            <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center gap-3 p-4 z-10 backdrop-blur-sm">
                                                <p class="text-white text-xs font-bold uppercase tracking-wider">Select Position</p>
                                                
                                                <div class="flex gap-3">
                                                    @foreach([1, 2, 3] as $pos)
                                                        <form action="{{ route('curator.challenges.select_winner', $challenge->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="submission_id" value="{{ $sub->id }}">
                                                            <input type="hidden" name="position" value="{{ $pos }}">
                                                            
                                                            <button type="submit" class="w-10 h-10 rounded-full font-bold flex items-center justify-center transition transform hover:scale-110 shadow-lg border-2 
                                                                {{ isset($winners[$pos]) && $winners[$pos]->submission_id == $sub->id 
                                                                    ? 'bg-green-500 text-white border-green-400 ring-2 ring-green-200' 
                                                                    : ($pos == 1 ? 'bg-yellow-400 text-yellow-900 border-yellow-300' : ($pos == 2 ? 'bg-gray-300 text-gray-900 border-gray-200' : 'bg-orange-400 text-white border-orange-300')) 
                                                                }}" title="Select as Winner #{{ $pos }}">
                                                                
                                                                @if(isset($winners[$pos]) && $winners[$pos]->submission_id == $sub->id)
                                                                    ✓
                                                                @else
                                                                    {{ $pos }}
                                                                @endif
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </div>

                                                <a href="{{ route('artworks.show', $sub->artwork->id) }}" target="_blank" class="mt-4 text-white text-xs underline hover:text-gray-300 flex items-center gap-1">
                                                    View Full Artwork 
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4 flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full overflow-hidden flex-shrink-0 border border-gray-100">
                                            @if($sub->user->profile_photo_path)
                                                <img src="{{ asset('storage/'.$sub->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-black flex items-center justify-center text-white text-[10px] font-bold">{{ substr($sub->user->name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-bold text-gray-900 truncate">{{ $sub->artwork->title }}</div>
                                            <div class="text-xs text-gray-500 truncate">by {{ $sub->user->name }}</div>
                                        </div>
                                        
                                        @if($sub->winner)
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs shadow-sm border border-white
                                                    {{ $sub->winner->position == 1 ? 'bg-yellow-400 text-yellow-900' : ($sub->winner->position == 2 ? 'bg-gray-300 text-gray-800' : 'bg-orange-300 text-white') }}" 
                                                    title="Winner #{{ $sub->winner->position }}">
                                                    #{{ $sub->winner->position }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $submissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                            <p class="text-gray-500">No submissions yet.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>