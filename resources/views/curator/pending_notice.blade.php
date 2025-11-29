<x-guest-layout>
    <div class="text-center py-10">
        <div class="w-20 h-20 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Application Under Review</h2>
        <p class="text-gray-500 max-w-sm mx-auto mb-8">
            Thank you for applying! Our admin team is currently reviewing your curator profile. You will receive an email once your account is approved.
        </p>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-black font-bold underline hover:text-gray-600">
                Log Out & Return Home
            </button>
        </form>
    </div>
</x-guest-layout>