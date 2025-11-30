<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ArtworkPublicController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base Query dengan Eager Loading (Optimasi Query)
        $query = Artwork::with(['user', 'category'])
            ->withCount(['likes', 'comments', 'favorites']); // Hitung jumlah interaksi

        // 2. Filter: Search Keyword
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        // 3. Filter: Category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // 4. Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('likes_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 5. Pagination
        $artworks = $query->paginate(12)->withQueryString();
        
        // 6. Data Pendukung
        $categories = Category::all();

        return view('public.artworks.index', compact('artworks', 'categories'));
    }

    public function favorites()
    {
        // Ambil artwork yang ada di tabel pivot 'favorites' milik user yg login
        $artworks = Auth::user()->favorites()->with('user')->latest()->paginate(12);
        
        // Kita bisa reuse view index, tapi kita kirim variabel flag 'isFavoritePage'
        // atau buat view terpisah. Agar estetik, kita buat view terpisah sedikit.
        return view('public.artworks.favorites', compact('artworks'));
    }

public function show(Artwork $artwork)
    {
        // 1. Eager Load Relasi (Agar performa cepat & data lengkap)
        // Kita butuh data: Pembuat (user), Kategori, dan Komentar beserta penulisnya
        $artwork->load(['user', 'category', 'comments.user']);

        // 2. Hitung jumlah Like, Favorite, dan Komentar
        $artwork->loadCount(['likes', 'favorites', 'comments']);

        // 3. Tampilkan View
        // Pastikan file view ini ada di: resources/views/artworks/show.blade.php
        return view('artworks.show', compact('artwork'));
    }
}