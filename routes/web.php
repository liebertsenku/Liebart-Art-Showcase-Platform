<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtworkController; // <-- PASTIKAN BARIS INI ADA
use App\Http\Controllers\ArtworkPublicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuratorPendingController; // <--- Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == 1. PUBLIC USER (GUEST) ROUTES ==
// Ini adalah route yang bisa diakses siapa saja
Route::get('/', function () {
    return view('welcome'); // Ini Homepage (Public) Anda
})->name('home');

// Contoh route publik lainnya
// Route::get('/artwork/{id}', [ArtworkController::class, 'show'])->name('artwork.detail');
// Route::get('/creator/{id}', [CreatorProfileController::class, 'show'])->name('creator.profile');
// Route::get('/challenge/{id}', [ChallengeController::class, 'show'])->name('challenge.detail');


// == 2. MEMBER (CREATOR) ROUTES ==
// Breeze sudah menyediakan '/dashboard' untuk 'auth'
// Kita bisa gunakan ini sebagai Homepage Member
Route::get('/dashboard', function () {
    
    $user = Auth::user();

    // 1. Jika Admin, tendang ke admin.dashboard
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // 2. Jika Curator, tendang ke dashboard-nya
    if ($user->isCurator()) {
        if ($user->isApproved()) {
            return redirect()->route('curator.dashboard');
        } else {
            return redirect()->route('curator.pending');
        }
    }

    // 3. Jika bukan keduanya, dia pasti Member. Tampilkan dashboard Member.
    return view('dashboard');

})->middleware(['auth']) // <-- Middleware-nya cukup 'auth'
   ->name('dashboard');


// Profile Management (dari Breeze)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route spesifik Member (My Artworks, My Favorites, dll)
    // Route::get('/my-artworks', ...)->middleware('role:member');
});


// == 3. CURATOR ROUTES ==
// Halaman 'Pending' (Hanya untuk curator pending)
Route::get('/curator/pending', [CuratorPendingController::class, 'index'])
    ->middleware(['auth', 'role:curator', 'curator.pending']) // <--- Kunci dengan middleware
    ->name('curator.pending');

// Dashboard Curator (Hanya untuk curator approved)
Route::middleware(['auth', 'role:curator', 'curator.approved'])->prefix('curator')->name('curator.')->group(function () {
    Route::get('/dashboard', function() {
        return view('curator.dashboard'); // Ganti dengan Controller Anda
    })->name('dashboard');
    
    // CRUD Challenge
    // Route::resource('/challenges', CuratorChallengeController::class);
});


// == 4. ADMIN ROUTES ==
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard'); // Ganti dengan Controller Anda
    })->name('dashboard');
    
    // User Management, Category Management, Moderation
    // Route::resource('/users', AdminUserController::class);
    // Route::resource('/categories', AdminCategoryController::class);
    // Route::get('/moderation', [AdminModerationController::class, 'index'])->name('moderation.queue');
});

// == MEMBER (CREATOR) ROUTES ==
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    // Route ini akan menangani:
    // GET /member/artworks (index)
    // GET /member/artworks/create (create)
    // POST /member/artworks (store)
    // GET /member/artworks/{artwork} (show) -> redirect ke publik
    // GET /member/artworks/{artwork}/edit (edit)
    // PUT/PATCH /member/artworks/{artwork} (update)
    // DELETE /member/artworks/{artwork} (destroy)
    Route::resource('artworks', ArtworkController::class);
});


// == PUBLIC ROUTES ==
// Route publik untuk melihat detail artwork
Route::get('/artworks/{artwork}', [ArtworkPublicController::class, 'show'])->name('artworks.show');

require __DIR__.'/auth.php';
