<?php

namespace App\Providers;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Contracts\Repositories\FriendshipRepositoryInterface;
use App\Contracts\Repositories\PostRepositoryInterface;
use App\Http\Resources\PostResource;
use App\Repositories\CommentRepository;
use App\Repositories\FriendshipRepository;
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
        $this->app->bind(CommentRepositoryInterface::class,CommentRepository::class);
        $this->app->bind(FriendshipRepositoryInterface::class,FriendshipRepository::class);
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
