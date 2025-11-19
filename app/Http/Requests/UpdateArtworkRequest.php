<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtworkRequest extends FormRequest
{
    /**
     * Otorisasi ditangani oleh Policy, tapi kita bisa cek di sini juga.
     */
    public function authorize(): bool
    {
        // Pastikan user yang login adalah pemilik artwork
        // 'artwork' adalah nama parameter di route resource
        return $this->user()->id === $this->artwork->user_id;
    }

    /**
     * Dapatkan aturan validasi.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Opsional saat update
            'tags' => ['nullable', 'string'],
        ];
    }
}