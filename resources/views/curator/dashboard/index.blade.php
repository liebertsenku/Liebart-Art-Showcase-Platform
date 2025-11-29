<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Curator Dashboard</h1>
                    <p class="text-gray-500 mt-2">Welcome back, {{ Auth::user()->name }}. Ready to discover new talents?</p>
                    <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Verified Curator
                    </div>
                </div>
                
                <div class="text-right hidden md:block">
                    <div class="text-sm text-gray-500">Current Role</div>
                    <div class="text-xl font-bold text-black">{{ Auth::user()->curatorProfile->organization_name ?? 'Organization' }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="group bg-black text-white p-8 rounded-[24px] shadow-lg relative overflow-hidden flex flex-col justify-between min-h-[240px] hover:shadow-xl transition duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gray-800 rounded-full mix-blend-overlay filter blur-2xl opacity-50 -mr-10 -mt-10"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Host a Challenge</h3>
                        <p class="text-gray-400 text-sm max-w-xs">Create a new theme, set rules, and invite members to submit their best artworks.</p>
                    </div>

                    <div class="relative z-10 mt-6">
                        <a href="{{ route('curator.challenges.create') }}" class="inline-flex items-center gap-2 bg-white text-black font-bold py-3 px-6 rounded-xl hover:bg-gray-200 transition transform group-hover:translate-x-1">
                            Create New Challenge &rarr;
                        </a>
                    </div>
                </div>

                <div class="group bg-white p-8 rounded-[24px] shadow-sm border border-gray-100 relative overflow-hidden flex flex-col justify-between min-h-[240px] hover:border-black/30 transition duration-300">
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Manage Challenges</h3>
                        <p class="text-gray-500 text-sm max-w-xs">View submissions, edit details, select winners, or close existing events.</p>
                    </div>

                    <div class="relative z-10 mt-6">
                        <a href="{{ route('curator.challenges.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-900 font-bold py-3 px-6 rounded-xl hover:border-black hover:bg-gray-50 transition">
                            View My List
                        </a>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-yellow-50 border border-yellow-100 rounded-[24px] p-6 flex items-start gap-4">
                <div class="w-10 h-10 bg-yellow-200 rounded-full flex items-center justify-center flex-shrink-0 text-yellow-800 font-bold">!</div>
                <div>
                    <h4 class="text-yellow-900 font-bold text-lg">Curator Tips</h4>
                    <p class="text-yellow-800 text-sm mt-1 leading-relaxed">
                        Make sure your challenge rules are clear. You can only select winners <strong>after</strong> the challenge end date has passed. Good luck finding the next masterpiece!
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>