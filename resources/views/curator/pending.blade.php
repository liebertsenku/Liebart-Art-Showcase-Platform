<x-guest-layout>
    <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center">Akun Anda Sedang Ditinjau</h1>
        <p class="mt-4 text-center text-gray-600">
            Terima kasih telah mendaftar sebagai Curator. Akun Anda saat ini sedang dalam proses peninjauan oleh Admin.
        </p>
        <p class="mt-2 text-center text-gray-600">
            Anda akan mendapatkan notifikasi email setelah akun Anda disetujui.
        </p>
        
        <div class="mt-6 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-primary-button>
                    {{ __('Log Out') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>