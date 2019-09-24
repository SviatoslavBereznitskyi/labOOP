<?php

namespace App\Providers;

use App\Repositories\Contracts\CommandRepository;
use App\Repositories\Contracts\SentMessagesRepository;
use App\Repositories\Contracts\SubscriptionRepository;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Repositories\CommandRepositoryEloquent;
use App\Repositories\SentMessagesRepositoryEloquent;
use App\Repositories\SubscriptionRepositoryEloquent;
use App\Repositories\TelegramUserRepositoryEloquent;
use App\Services\CommandService;
use App\Services\Contracts\CommandServiceInterface;
use App\Services\Contracts\MailingServiceInterface;
use App\Services\Contracts\SubscriptionServiceInterface;
use App\Services\Contracts\TelegramServiceInterface;
use App\Services\MailingService;
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
        $this->app->bind(CommandRepository::class, CommandRepositoryEloquent::class);
        $this->app->bind(SubscriptionRepository::class, SubscriptionRepositoryEloquent::class);
        $this->app->bind(TelegramServiceInterface::class, TelegramService::class);
        $this->app->bind(SubscriptionServiceInterface::class, SubscriptionService::class);
        $this->app->bind(CommandServiceInterface::class, CommandService::class);
        $this->app->bind(MailingServiceInterface::class, MailingService::class);
        $this->app->bind(SentMessagesRepository::class, SentMessagesRepositoryEloquent::class);
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
