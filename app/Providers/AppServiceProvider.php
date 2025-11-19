<?php

namespace App\Providers;

use App\Models\Artwork;
use App\Policies\ArtworkPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Artwork::class => ArtworkPolicy::class, // <-- Tambahkan baris ini
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
