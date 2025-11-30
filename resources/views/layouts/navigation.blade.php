<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm' : 'bg-transparent'"
     class="fixed w-full top-0 z-50 transition-all duration-300 border-b border-gray-100/50">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center font-bold text-xl group-hover:rotate-12 transition duration-300">
                        L
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">LiebArt</span>
                </a>

                <div class="hidden sm:flex sm:items-center space-x-6">
                    
                    @auth
                        {{-- A. NAVIGASI ADMIN --}}
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 transition {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.moderation.index') }}" class="text-sm font-medium text-gray-500 hover:text-red-600 transition {{ request()->routeIs('admin.moderation.*') ? 'text-red-600' : '' }}">
                                Moderation
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('admin.users.*') ? 'text-black' : '' }}">
                                Users
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('admin.categories.*') ? 'text-black' : '' }}">
                                Categories
                            </a>

                        {{-- B. NAVIGASI CURATOR --}}
                        @elseif(Auth::user()->role === 'curator')
                            <a href="{{ route('curator.dashboard') }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 transition {{ request()->routeIs('curator.dashboard') ? 'text-blue-600' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('curator.challenges.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('curator.challenges.*') ? 'text-black' : '' }}">
                                My Challenges
                            </a>
                            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-black transition">
                                View Gallery
                            </a>

                        {{-- C. NAVIGASI MEMBER --}}
                        @else
                            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('home') || request()->routeIs('artworks.index') ? 'text-black font-bold' : '' }}">
                                Explore
                            </a>
                            <a href="{{ route('public.challenges.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('public.challenges.*') ? 'text-black font-bold' : '' }}">
                                Challenges 
                            </a>
                            <a href="{{ route('member.artworks.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('member.artworks.*') ? 'text-black font-bold' : '' }}">
                                My Works
                            </a>
                        @endif

                    @else
                        {{-- D. NAVIGASI GUEST --}}
                        <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('home') ? 'text-black font-bold' : '' }}">
                            Explore
                        </a>
                        <a href="{{ route('public.challenges.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition {{ request()->routeIs('public.challenges.*') ? 'text-black font-bold' : '' }}">
                            Challenges
                        </a>
                    @endauth

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                
                @auth
                    @if(Auth::user()->role === 'member')
                        <a href="{{ route('artworks.favorites') }}" class="relative p-2 text-gray-400 hover:text-red-500 transition group" title="My Favorites">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition duration-200 {{ request()->routeIs('artworks.favorites') ? 'text-red-500 fill-current' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>
                        <div class="h-6 w-px bg-gray-200"></div>
                    @endif

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-bold text-gray-900 group-hover:text-black">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">
                                    {{ Auth::user()->role === 'curator' ? 'Curator' : (Auth::user()->role === 'admin' ? 'Admin' : 'Member') }}
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border-2 border-transparent group-hover:border-black transition p-[1px]">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <div class="w-full h-full bg-black flex items-center justify-center text-white font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             style="display: none;"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                            
                            @if(Auth::user()->role === 'member')
                                <a href="{{ route('member.show', Auth::id()) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Public Portfolio
                                </a>
                                <a href="{{ route('member.artworks.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Manage Artworks
                                </a>
                            @endif

                            @if(Auth::user()->role === 'curator')
                                <a href="{{ route('curator.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Dashboard
                                </a>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                    Admin Dashboard
                                </a>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>

                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-black transition px-4 py-2 rounded-xl hover:bg-gray-100">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-bold bg-black text-white px-5 py-2.5 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Sign up
                        </a>
                    </div>
                @endauth

            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Explore Artworks
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('public.challenges.index')" :active="request()->routeIs('public.challenges.*')">
                Challenges 🏆
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('artworks.favorites')" :active="request()->routeIs('artworks.favorites')">
                    My Favorites
                </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-4 border-t border-gray-200 px-4">
            @auth
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-black flex items-center justify-center text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    @if(Auth::user()->role === 'member')
                        <a href="{{ route('member.show', Auth::id()) }}" class="block w-full text-left py-2 text-sm text-gray-600">Public Portfolio</a>
                    @endif
                    
                    @if(Auth::user()->role === 'curator')
                        <a href="{{ route('curator.dashboard') }}" class="block w-full text-left py-2 text-sm text-gray-600">Curator Dashboard</a>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-left py-2 text-sm text-gray-600">Admin Dashboard</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 text-sm text-red-600 font-bold">Log Out</button>
                    </form>
                </div>
            @else
                <div class="space-y-3 mt-2">
                    <a href="{{ route('login') }}" class="block w-full text-center py-2 border border-gray-300 rounded-lg text-gray-700 font-bold">Log in</a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-2 bg-black text-white rounded-lg font-bold">Sign up</a>
                </div>
            @endauth
        </div>
    </div>
</nav>