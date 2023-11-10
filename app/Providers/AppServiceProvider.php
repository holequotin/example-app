<?php

namespace App\Providers;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(PostRepositoryInterface::class,PostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        PostResource::withoutWrapping();
    }
}
