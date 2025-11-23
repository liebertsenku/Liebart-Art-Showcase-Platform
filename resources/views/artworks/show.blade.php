<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $artwork->title ?? 'Artwork Detail' }} - LiebArt</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F4F2] text-gray-900">

    <nav class="w-full bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-black rounded text-white flex items-center justify-center font-bold">L</div>
                    <span class="font-bold text-xl tracking-tight">LiebArt</span>
                </a>
                
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm text-gray-500">Hi, {{ Auth::user()->name }}</span>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-black">Log in</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto">
            
            <div class="mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-500 hover:text-black transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="m15 18-6-6 6-6"/></svg>
                    Back to Gallery
                </a>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm overflow-hidden border border-gray-100">
                
                <div class="w-full bg-gray-100 flex justify-center items-center overflow-hidden min-h-[400px]">
                    @if($artwork->image) 
    
                        <div class="w-full bg-gray-100 flex justify-center items-center overflow-hidden">
                            <img 
                                src="{{ asset('storage/' . $artwork->image) }}" 
                                alt="{{ $artwork->title }}" 
                                class="w-full h-auto max-h-[600px] object-contain"
                            >
                        </div>

                    @else
                        <div class="w-full h-64 bg-gray-200 flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>No Image Available</span>
                            <span class="text-xs mt-1">(Debug: Kolom 'image' kosong atau salah panggil)</span>
                        </div>
                    @endif
                </div>

                <div class="p-8 sm:p-10">
                    <div class="flex flex-col md:flex-row gap-8 justify-between items-start">
                        
                        <div class="flex-1 w-full">
                            
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide mb-3">
                                {{ $artwork->category->name ?? 'Uncategorized' }}
                            </span>

                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 leading-tight">
                                {{ $artwork->title }}
                            </h1>

                            <p class="text-gray-400 text-sm mb-6">
                                Posted on {{ \Carbon\Carbon::parse($artwork->created_at)->format('d F Y') }}
                            </p>

                            <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                                <p>{{ $artwork->description }}</p>
                            </div>

                            <div class="mt-8 flex flex-wrap gap-2">
                                {{-- Gunakan '?? []' untuk berjaga-jaga jika tags bernilai NULL --}}
                                @foreach(($artwork->tags ?? []) as $tag)
                                    <span class="px-4 py-2 bg-[#F5F4F2] text-gray-700 text-sm rounded-lg font-medium">
                                        #{{ $tag }}
                                    </span>
                                @endforeach

                                {{-- Pesan jika kosong --}}
                                @if(empty($artwork->tags))
                                    <span class="text-gray-400 text-sm italic">No tags</span>
                                @endif
                            </div>
                        </div>

                        <div class="w-full md:w-72 flex-shrink-0">
                            <div class="bg-[#FAFAFA] rounded-2xl p-6 border border-gray-100">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Artist</h3>
                                
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr($artwork->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $artwork->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">Member</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <button class="w-full bg-black text-white font-medium py-3 px-4 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200 flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                        Appreciate
                                    </button>
                                    
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
    </div>
</body>
</html>