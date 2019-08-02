<?php

namespace App\Providers;

use App\Repositories\Contracts\MessageRepository;
use App\Repositories\Contracts\SubscriptionRepository;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Repositories\MessageRepositoryEloquent;
use App\Repositories\SubscriptionRepositoryEloquent;
use App\Repositories\TelegramUserRepositoryEloquent;
use App\Services\CommandService;
use App\Services\Contracts\CommandServiceInterface;
use App\Services\Contracts\SubscriptionServiceInterface;
use App\Services\Contracts\TelegramServiceInterface;
use App\Services\SubscriptionService;
use App\Services\TelegramService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TelegramUserRepository::class, TelegramUserRepositoryEloquent::class);
        $this->app->bind(MessageRepository::class, MessageRepositoryEloquent::class);
        $this->app->bind(SubscriptionRepository::class, SubscriptionRepositoryEloquent::class);
        $this->app->bind(TelegramServiceInterface::class, TelegramService::class);
        $this->app->bind(SubscriptionServiceInterface::class, SubscriptionService::class);
        $this->app->bind(CommandServiceInterface::class, CommandService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
