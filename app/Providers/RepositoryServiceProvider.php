<?php

namespace App\Providers;

use App\Repositories\Contracts\MessageRepository;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Repositories\MessageRepositoryEloquent;
use App\Repositories\TelegramUserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
