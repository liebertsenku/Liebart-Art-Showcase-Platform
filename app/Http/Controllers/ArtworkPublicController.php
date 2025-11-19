<?php
// app/Http/Controllers/ArtworkPublicController.php
namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkPublicController extends Controller
{
    /**
     * Menampilkan halaman detail artwork untuk publik.
     */
    public function show(Artwork $artwork)
    {
        // Load relasi user dan category untuk ditampilkan
        $artwork->load(['user', 'category']);
        
        return view('artworks.show', compact('artwork'));
    }
}