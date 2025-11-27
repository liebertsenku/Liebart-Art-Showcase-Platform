<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\ArtworkPublicController;
use App\Http\Controllers\Member\InteractionController;
use App\Http\Controllers\Member\ChallengeSubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuratorPendingController;
use Illuminate\Support\Facades\Auth; // Jangan lupa import Auth

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// 1. HOME = PUBLIC GALLERY
Route::get('/', [ArtworkPublicController::class, 'index'])->name('home');

// 2. FAVORITES PAGE (Hanya untuk member login)
Route::middleware('auth')->group(function () {
    Route::get('/my-favorites', [ArtworkPublicController::class, 'favorites'])->name('artworks.favorites');
});

// Route::get('/member/{id}', [ProfileController::class, 'show'])->name('member.show');

// == ROUTE MEMBER ARTWORKS (CRUD) ==
Route::middleware(['auth', 'role:member']) // Cek login & role member
    ->prefix('member')                     // URL awalan: /member/...
    ->name('member.')                      // Nama route awalan: member....
    ->group(function () {
        
        // Ini akan otomatis membuat route:
        // index   -> member.artworks.index
        // create  -> member.artworks.create
        // store   -> member.artworks.store
        // edit    -> member.artworks.edit
        // update  -> member.artworks.update
        // destroy -> member.artworks.destroy
        Route::resource('artworks', ArtworkController::class);
        
    });

    Route::get('/artworks', [ArtworkPublicController::class, 'index'])->name('artworks.index');


// == 1. ROOT ROUTE (DISPATCHER) ==
// Route::get('/', function () {
//     // A. Jika User Sudah Login
//     if (Auth::check()) {
//         $user = Auth::user();

//         // Cek Role Admin
//         if ($user->role === 'admin' || (method_exists($user, 'isAdmin') && $user->isAdmin())) { 
//             return redirect()->route('admin.dashboard');
//         }

//         // Jika Member/Curator -> Ke Profil Sendiri
//         return redirect()->route('member.show', $user->id);
//     }

//     // B. Jika Belum Login -> Ke Halaman Login
//     return redirect()->route('login');
// })->name('home');


Route::get('/member/{id}', [ProfileController::class, 'show'])->name('profile.show');


// == 2. ROUTE PUBLIK PROFILE (INI YANG HILANG SEBELUMNYA) ==
// Route ini menangani halaman profil publik (Portfolio)
// URL-nya /member/{id}, tapi nama routenya kita set 'profile.show' sesuai request Anda
Route::get('/member/{id}', [ProfileController::class, 'show'])->name('member.show');


// == 3. MEMBER (CREATOR) ROUTES ==
Route::middleware(['auth'])->group(function () {
    // Settings Profile (Edit, Update, Delete)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// == 4. CURATOR ROUTES ==
Route::get('/curator/pending', [CuratorPendingController::class, 'index'])
    ->middleware(['auth', 'role:curator', 'curator.pending'])
    ->name('curator.pending');

Route::middleware(['auth', 'role:curator', 'curator.approved'])->prefix('curator')->name('curator.')->group(function () {
    Route::get('/dashboard', function() {
        return view('curator.dashboard');
    })->name('dashboard');
});


// == 5. ADMIN ROUTES ==
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');
});


// == 6. ARTWORK CRUD ROUTES ==
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::resource('artworks', ArtworkController::class);
});


// == 7. PUBLIC ARTWORK DETAIL ==
Route::get('/artworks/{artwork}', [ArtworkPublicController::class, 'show'])->name('artworks.show');

Route::middleware(['auth', 'role:member'])->group(function () {
    
    // --- Interaksi Artwork ---
    Route::post('/artworks/{artwork}/like', [InteractionController::class, 'toggleLike'])->name('artworks.like');
    Route::post('/artworks/{artwork}/favorite', [InteractionController::class, 'toggleFavorite'])->name('artworks.favorite');
    
    // Komentar
    Route::post('/artworks/{artwork}/comment', [InteractionController::class, 'storeComment'])->name('artworks.comment.store');
    Route::delete('/comments/{comment}', [InteractionController::class, 'destroyComment'])->name('comments.destroy');
    
    // Report
    Route::post('/artworks/{artwork}/report', [InteractionController::class, 'storeReport'])->name('artworks.report');

    // --- Challenge Submission ---
    Route::get('/challenges/{challenge}/submit', [ChallengeSubmissionController::class, 'create'])->name('challenges.submit.form');
    Route::post('/challenges/{challenge}/submit', [ChallengeSubmissionController::class, 'store'])->name('challenges.submit.store');

});

require __DIR__.'/auth.php';