<?php

// app/Http/Requests/StoreArtworkRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtworkRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     * Kita asumsikan route sudah dilindungi middleware 'auth' & 'isMember'.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Wajib saat create
            'tags' => ['nullable', 'string'], // Akan kita proses sebagai string dipisah koma
        ];
    }
}