<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Implementation\RedisPubSubPublisher;
use App\Helpers\IPubSubPublisher;
use App\Repository\NoteRepository;
use App\Repository\NoteRepositoryInterface;
use App\Services\INoteService;
use App\Services\NoteService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(INoteService::class, NoteService::class);
        $this->app->bind(NoteRepositoryInterface::class, NoteRepository::class);
        $this->app->bind(IPubSubPublisher::class, RedisPubSubPublisher::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
