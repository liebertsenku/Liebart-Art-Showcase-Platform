<?php

// app/Http/Controllers/ArtworkController.php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArtworkRequest; // <-- Gunakan Form Request
use App\Http\Requests\UpdateArtworkRequest; // <-- Gunakan Form Request

class ArtworkController extends Controller
{
    /**
     * Terapkan Policy ke semua metode resource secara otomatis.
     */
    public function __construct()
    {
        // 'artwork' adalah nama parameter di route
        // 'store' tidak perlu dicek policy karena belum ada artwork
        $this->authorizeResource(Artwork::class, 'artwork', [
            'except' => ['index', 'create', 'store'],
        ]);
    }

    /**
     * Menampilkan daftar karya milik user yang sedang login.
     */
    public function index()
    {
        $artworks = Auth::user()->artworks()->latest()->paginate(10);
        
        return view('member.artworks.index', compact('artworks'));
    }

    /**
     * Menampilkan form untuk membuat karya baru.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('member.artworks.create', compact('categories'));
    }

    /**
     * Menyimpan karya baru ke database.
     */
    public function store(StoreArtworkRequest $request)
    {
        // 1. Handle File Upload
        $path = $request->file('image')->store('artworks', 'public');

        // 2. Proses Tags (dari string "tag1,tag2" menjadi array)
        $tags = $request->input('tags') ? explode(',', $request->input('tags')) : null;

        // 3. Buat Artwork
        Auth::user()->artworks()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'image' => $path,
            'tags' => $tags,
        ]);

        return redirect()->route('member.artworks.index')
                         ->with('success', 'Karya berhasil ditambahkan.');
    }

    /**
     * (Opsional) Menampilkan detail karya di area member.
     * Anda bisa juga redirect ke route publik.
     */
    public function show(Artwork $artwork)
    {
        // Redirect ke halaman detail publik
        return redirect()->route('artworks.show', $artwork);
    }

    /**
     * Menampilkan form untuk mengedit karya.
     */
    public function edit(Artwork $artwork)
    {
        $categories = Category::orderBy('name')->get();
        
        // Ubah tags dari array kembali ke string untuk form input
        $artwork->tags_string = $artwork->tags ? implode(',', $artwork->tags) : '';

        return view('member.artworks.edit', compact('artwork', 'categories'));
    }

    /**
     * Mengupdate karya di database.
     */
    public function update(UpdateArtworkRequest $request, Artwork $artwork)
    {
        $data = $request->validated();
        
        // 1. Handle File Upload (jika ada file baru)
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($artwork->image) {
                Storage::disk('public')->delete($artwork->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('artworks', 'public');
        }

        // 2. Proses Tags
        $data['tags'] = $request->input('tags') ? explode(',', $request->input('tags')) : null;

        // 3. Update Artwork
        $artwork->update($data);

        return redirect()->route('member.artworks.index')
                         ->with('success', 'Karya berhasil diperbarui.');
    }

    /**
     * Menghapus karya dari database.
     */
    public function destroy(Artwork $artwork)
    {
        // Hapus file gambar dari storage
        if ($artwork->image) {
            Storage::disk('public')->delete($artwork->image);
        }

        // Hapus data dari database
        $artwork->delete();

        return redirect()->route('member.artworks.index')
                         ->with('success', 'Karya berhasil dihapus.');
    }
}