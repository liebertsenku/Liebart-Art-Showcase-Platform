<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F4F2] text-gray-900">

    <!-- 1. INCLUDE NAVBAR GLOBAL (Konsisten dengan Public/Home) -->
    <!-- Pastikan file resources/views/layouts/navigation.blade.php sudah Anda update sesuai langkah sebelumnya -->
    @include('layouts.navigation')

    <!-- 2. WRAPPER UTAMA -->
    <!-- Tambahkan class 'pt-20' agar konten tidak tertutup Navbar yang posisinya Fixed -->
    <main class="pt-20">
        
        <!-- Profile Header -->
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-[#F5F4F2] overflow-hidden shadow-sm">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-black flex items-center justify-center text-white text-4xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $user->name }}</h1>
                        
                        <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase tracking-wide">
                            Member
                        </span>
                        
                        <p class="mt-4 text-gray-600 leading-relaxed max-w-2xl mx-auto md:mx-0">
                            {{ $user->bio ?? 'This user has not written a bio yet.' }}
                        </p>

                        <!-- Stats -->
                        <div class="flex items-center justify-center md:justify-start gap-8 mt-6 border-y border-gray-100 py-4 w-full md:w-fit">
                            <div class="text-center md:text-left">
                                <span class="block font-bold text-xl text-gray-900">{{ $stats['artworks'] ?? 0 }}</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Artworks</span>
                            </div>
                            <div class="text-center md:text-left">
                                <span class="block font-bold text-xl text-gray-900">{{ number_format($stats['followers'] ?? 0) }}</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Followers</span>
                            </div>
                            <div class="text-center md:text-left">
                                <span class="block font-bold text-xl text-gray-900">{{ number_format($stats['likes'] ?? 0) }}</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Likes</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-6">
                            
                            @if(Auth::id() === $user->id)
                                {{-- SKENARIO 1: PEMILIK PROFIL --}}
                                
                                <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-black text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit Profile
                                </a>

                                <a href="{{ route('member.artworks.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:border-black hover:text-black transition shadow-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Manage Artworks
                                </a>

                            @else
                                {{-- SKENARIO 2: PENGUNJUNG LAIN --}}
                                
                                <button class="px-6 py-2.5 bg-black text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                                    Follow
                                </button>
                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Artwork Gallery -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Artworks</h2>
            
            @if($user->artworks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($user->artworks as $artwork)
                        <a href="{{ route('artworks.show', $artwork) }}" class="group block">
                            <div class="bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-md transition duration-300 border border-gray-100">
                                
                                <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                    
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 truncate">{{ $artwork->title }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $artwork->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-[24px] p-12 text-center border border-gray-100 shadow-sm">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No artworks yet</h3>
                    <p class="text-gray-500 mt-1">This user hasn't uploaded any masterpiece.</p>
                    
                    @if(Auth::id() === $user->id)
                        <div class="mt-6">
                            <a href="{{ route('member.artworks.create') }}" class="text-sm font-bold text-black hover:underline">
                                Upload your first artwork &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </main>

</body>
</html>