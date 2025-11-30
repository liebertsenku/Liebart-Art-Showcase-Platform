<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F4F2] text-gray-900">

    @include('layouts.navigation')

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
                        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-2">
                            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $user->name }}</h1>
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase tracking-wide w-fit mx-auto md:mx-0">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        
                        <p class="mt-4 text-gray-600 leading-relaxed max-w-2xl mx-auto md:mx-0">
                            {{ $user->bio ?? 'This user has not written a bio yet.' }}
                        </p>

                        <!-- INFO BAR: Total Artwork & Social Links -->
                        <div class="flex flex-col md:flex-row items-center gap-6 mt-6 border-t border-gray-100 pt-6">
                            
                            <!-- 1. Total Artworks (Data Asli) -->
                            <div class="text-center md:text-left pr-0 md:pr-6 md:border-r border-gray-200">
                                <span class="block font-bold text-xl text-gray-900">{{ $user->artworks->count() }}</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Artworks</span>
                            </div>

                            <!-- 2. Social Links (Pengganti Follower/Like Dummy) -->
                            <div class="flex items-center gap-3">
                                @if($user->website || $user->instagram || $user->behance)
                                    
                                    <!-- Website -->
                                    @if($user->website)
                                        <a href="{{ $user->website }}" target="_blank" class="p-2 bg-gray-100 rounded-full hover:bg-black hover:text-white transition text-gray-600" title="Website">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                        </a>
                                    @endif

                                    <!-- Instagram -->
                                    @if($user->instagram)
                                        <a href="https://instagram.com/{{ $user->instagram }}" target="_blank" class="p-2 bg-gray-100 rounded-full hover:bg-pink-600 hover:text-white transition text-gray-600" title="Instagram">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.217 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.217-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.247-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.468 2.525c.637-.247 1.363-.415 2.428-.465C8.944 2.013 9.283 2 12 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a5 5 0 100 10 5 5 0 000-10z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 6.5h.01" /></svg>
                                        </a>
                                    @endif

                                    <!-- Behance -->
                                    @if($user->behance)
                                        <a href="https://behance.net/{{ $user->behance }}" target="_blank" class="p-2 bg-gray-100 rounded-full hover:bg-blue-600 hover:text-white transition text-gray-600" title="Behance">
                                            <!-- Simple Behance Icon -->
                                            <span class="font-bold text-xs">Be</span>
                                        </a>
                                    @endif

                                @else
                                    <span class="text-sm text-gray-400 italic">No external links.</span>
                                @endif
                            </div>

                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-8">
                            @if(Auth::id() === $user->id)
                                <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-black text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200 flex items-center gap-2">
                                    Edit Profile
                                </a>
                                <a href="{{ route('member.artworks.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:border-black hover:text-black transition shadow-sm flex items-center gap-2">
                                    Manage Artworks
                                </a>
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
                        <!-- Card Component -->
                        <a href="{{ route('artworks.show', $artwork) }}" class="group block h-full">
                            <div class="bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-md transition duration-300 border border-gray-100 h-full flex flex-col">
                                
                                <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
                                    @if($artwork->image)
                                        <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                    @else
                                        <div class="w-full h-full p-6 flex flex-col justify-center items-center text-center bg-white">
                                            <span class="text-3xl text-gray-200 mb-2 font-serif">❝</span>
                                            <p class="text-gray-800 font-serif text-xs leading-relaxed line-clamp-3 italic">
                                                {{ $artwork->description }}
                                            </p>
                                        </div>
                                    @endif
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
                    <h3 class="text-lg font-bold text-gray-900">No artworks yet</h3>
                    <p class="text-gray-500 mt-1">This user hasn't uploaded any masterpiece.</p>
                </div>
            @endif
        </div>

    </main>

</body>
</html>