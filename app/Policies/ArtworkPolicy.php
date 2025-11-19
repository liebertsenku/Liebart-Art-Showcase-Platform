<?php

namespace App\Policies;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArtworkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Artwork $artwork): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user dapat mengupdate model.
     */
    public function update(User $user, Artwork $artwork): bool
    {
        // Hanya user yang memiliki artwork yang bisa mengupdatenya
        return $user->id === $artwork->user_id;
    }

    /**
     * Tentukan apakah user dapat menghapus model.
     */
    public function delete(User $user, Artwork $artwork): bool
    {
        // Hanya user yang memiliki artwork yang bisa menghapusnya
        return $user->id === $artwork->user_id;
    }
    
    // Kita tidak perlu create, view, dll, karena itu ditangani oleh route middleware

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Artwork $artwork): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Artwork $artwork): bool
    {
        return false;
    }
}
