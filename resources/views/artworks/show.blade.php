<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $artwork->title ?? 'Artwork Detail' }} - LiebArt</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F4F2] text-gray-900">

    @include('layouts.navigation')

    <main class="pt-20 pb-12 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto">
            
            <div class="mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-500 hover:text-black transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="m15 18-6-6 6-6"/></svg>
                    Back
                </a>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm overflow-hidden border border-gray-100">
                
                @if($artwork->image)
                    <div class="w-full bg-gray-100 flex justify-center items-center overflow-hidden min-h-[400px]">
                        <img 
                            src="{{ asset('storage/' . $artwork->image) }}" 
                            alt="{{ $artwork->title }}" 
                            class="w-full h-auto max-h-[800px] object-contain"
                        >
                    </div>
                @endif

                <div class="p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row gap-12 justify-between items-start">
                        
                        <div class="flex-1 w-full">
                            
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide mb-4">
                                {{ $artwork->category->name ?? 'Uncategorized' }}
                            </span>

                            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight {{ !$artwork->image ? 'font-serif' : '' }}">
                                {{ $artwork->title }}
                            </h1>

                            <p class="text-gray-400 text-sm mb-8 pb-8 border-b border-gray-100">
                                Posted on {{ \Carbon\Carbon::parse($artwork->created_at)->format('d F Y') }}
                            </p>

                            <div class="prose prose-lg prose-gray max-w-none text-gray-800 leading-loose {{ !$artwork->image ? 'font-serif' : '' }} whitespace-pre-line">
                                {{ $artwork->description }}
                            </div>

                            <div class="mt-12 flex flex-wrap gap-2 border-b border-gray-100 pb-8 mb-8">
                                @foreach(($artwork->tags ?? []) as $tag)
                                    <span class="px-4 py-2 bg-[#F5F4F2] text-gray-700 text-sm rounded-lg font-medium">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>

                            <div id="comments-section" x-data="{ reportCommentId: null, showCommentModal: false }">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                    Comments <span class="bg-gray-100 text-gray-600 text-sm px-2 py-1 rounded-full">{{ $artwork->comments->count() }}</span>
                                </h3>

                                @auth
                                    <form action="{{ route('artworks.comment.store', $artwork->id) }}" method="POST" class="mb-8 flex gap-4">
                                        @csrf
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                            @if(Auth::user()->profile_photo_path)
                                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-black flex items-center justify-center text-white text-[10px] font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <textarea name="body" rows="2" class="w-full bg-[#F9F9F9] border-transparent rounded-xl focus:border-black focus:ring-black px-4 py-3 text-sm transition" placeholder="Add a comment..."></textarea>
                                            <div class="flex justify-end mt-2">
                                                <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition">Post</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="bg-gray-50 p-4 rounded-xl text-center mb-8">
                                        <p class="text-gray-500 text-sm">Please <a href="{{ route('login') }}" class="text-black font-bold underline">log in</a> to join the discussion.</p>
                                    </div>
                                @endauth

                                <div class="space-y-6">
                                    @forelse($artwork->comments as $comment)
                                        <div class="flex gap-4 group/comment">
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                                @if($comment->user->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $comment->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-black flex items-center justify-center text-white text-[10px] font-bold">{{ substr($comment->user->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="bg-[#FAFAFA] p-4 rounded-2xl rounded-tl-none border border-gray-100 relative">
                                                    <div class="flex justify-between items-start mb-1">
                                                        <h4 class="font-bold text-sm text-gray-900">{{ $comment->user->name }}</h4>
                                                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $comment->body }}</p>

                                                    @auth
                                                        @if(Auth::id() !== $comment->user_id)
                                                            <button @click="reportCommentId = {{ $comment->id }}; showCommentModal = true" 
                                                                    class="absolute top-2 right-2 text-gray-300 hover:text-red-500 opacity-0 group-hover/comment:opacity-100 transition" 
                                                                    title="Report Comment">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v6a2 2 0 01-2 2H2.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8a2 2 0 01-2-2h-5m-5 4h5"/></svg>
                                                            </button>
                                                        @endif
                                                    @endauth
                                                </div>
                                                
                                                @if(Auth::id() === $comment->user_id)
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-1 ml-2">
                                                        @csrf @method('DELETE')
                                                        <button class="text-xs text-red-400 hover:text-red-600 font-medium transition">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm italic">No comments yet. Be the first to share your thoughts!</p>
                                    @endforelse
                                </div>

                                @auth
                                    <div x-show="showCommentModal" style="display: none;" 
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                        <div @click.away="showCommentModal = false" class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
                                            <h3 class="text-lg font-bold text-gray-900 mb-2">Report Comment</h3>
                                            <p class="text-sm text-gray-500 mb-4">Why is this comment inappropriate?</p>
                                            
                                            <form x-bind:action="'/comments/' + reportCommentId + '/report'" method="POST">
                                                @csrf
                                                <div class="space-y-3 mb-4">
                                                    <select name="reason" class="w-full bg-gray-50 border-transparent rounded-lg focus:border-black focus:ring-black text-sm">
                                                        <option value="Spam">Spam or Advertising</option>
                                                        <option value="Hate Speech">Hate Speech / Harassment</option>
                                                        <option value="Inappropriate">Inappropriate Content</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" @click="showCommentModal = false" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-black">Cancel</button>
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700">Submit Report</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endauth

                            </div>
                            </div>

                        <div class="w-full md:w-72 flex-shrink-0">
                            <div class="bg-[#FAFAFA] rounded-2xl p-6 border border-gray-100 sticky top-24">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Artist</h3>
                                
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center text-white font-bold text-lg overflow-hidden">
                                        @if($artwork->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $artwork->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($artwork->user->name ?? 'A', 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('member.show', $artwork->user->id) }}" class="font-bold text-gray-900 hover:underline block truncate max-w-[150px]">
                                            {{ $artwork->user->name ?? 'Unknown' }}
                                        </a>
                                        <p class="text-xs text-gray-500">Member</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <a href="#comments-section" class="w-full bg-black text-white font-medium py-3 px-4 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200 flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        View Comments
                                    </a>
                                    
                                    @if(Auth::id() === ($artwork->user_id ?? 0))
                                    <a href="{{ route('member.artworks.edit', $artwork->id) }}" class="block w-full text-center bg-white border border-gray-200 text-gray-900 font-medium py-3 px-4 rounded-xl hover:bg-gray-50 transition">
                                        Edit Artwork
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>