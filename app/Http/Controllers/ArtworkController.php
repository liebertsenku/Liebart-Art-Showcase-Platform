<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Menampilkan daftar karya milik user yang sedang login.
     */
    public function index()
    {
        // Ambil artwork hanya milik user yang sedang login
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
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            
            // Logika: Image boleh kosong, TAPI jika kosong, description WAJIB ada (untuk Text Post)
            'image' => 'nullable|image|max:2048', // Max 2MB
            'description' => 'required_without:image|string', 
        ], [
            'description.required_without' => 'Please write a description/story if you are not uploading an image.',
        ]);

        // 2. Handle File Upload
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('artworks', 'public');
        }

        // 3. Proses Tags (String "tag1, tag2" -> Array ["tag1", "tag2"])
        $tags = null;
        if ($request->input('tags')) {
            $tagsArray = explode(',', $request->input('tags'));
            $tags = array_map('trim', $tagsArray); // Hapus spasi berlebih
        }

        // 4. Simpan ke Database
        Auth::user()->artworks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $path,
            'tags' => $tags,
        ]);

        return redirect()->route('member.artworks.index')
                         ->with('success', 'Artwork uploaded successfully.');
    }

    /**
     * Menampilkan detail karya (Redirect ke Public View).
     */
    public function show(Artwork $artwork)
    {
        // Redirect ke tampilan publik yang sudah bagus
        return redirect()->route('artworks.show', $artwork);
    }

    /**
     * Menampilkan form untuk mengedit karya.
     */
    public function edit(Artwork $artwork)
    {
        // Security: Pastikan hanya pemilik yang bisa edit
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::orderBy('name')->get();
        
        // Ubah array tags menjadi string (dipisah koma) untuk ditampilkan di input form
        // Contoh: ["Digital", "Art"] -> "Digital, Art"
        $tagsString = '';
        if ($artwork->tags && is_array($artwork->tags)) {
            $tagsString = implode(', ', $artwork->tags);
        }

        return view('member.artworks.edit', compact('artwork', 'categories', 'tagsString'));
    }

    /**
     * Mengupdate karya di database.
     */
    public function update(Request $request, Artwork $artwork)
    {
        // Security: Pastikan hanya pemilik yang bisa update
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 1. Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            // Jika gambar lama kosong DAN tidak upload gambar baru -> deskripsi wajib
            'description' => ($artwork->image ? 'nullable' : 'required_without:image') . '|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];

        // 2. Handle File Upload (Jika ada gambar baru)
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($artwork->image && Storage::disk('public')->exists($artwork->image)) {
                Storage::disk('public')->delete($artwork->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('artworks', 'public');
        }

        // 3. Proses Tags
        if ($request->filled('tags')) {
            $tagsArray = explode(',', $request->input('tags'));
            $data['tags'] = array_map('trim', $tagsArray);
        } else {
            $data['tags'] = null;
        }

        // 4. Update Database
        $artwork->update($data);

        return redirect()->route('member.artworks.index')
                         ->with('success', 'Artwork updated successfully.');
    }

    /**
     * Menghapus karya dari database.
     */
    public function destroy(Artwork $artwork)
    {
        // Security: Pastikan hanya pemilik yang bisa hapus
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file gambar dari storage
        if ($artwork->image && Storage::disk('public')->exists($artwork->image)) {
            Storage::disk('public')->delete($artwork->image);
        }

        // Hapus data dari database
        $artwork->delete();

        return redirect()->route('member.artworks.index')
                         ->with('success', 'Artwork deleted successfully.');
    }
}