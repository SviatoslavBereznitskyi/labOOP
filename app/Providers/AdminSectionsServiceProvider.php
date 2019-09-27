<?php

namespace App\Providers;

use App\Models\Settings;
use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Models\User;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        User::class => 'App\Http\Sections\Users',
        TelegramUser::class => 'App\Http\Sections\TelegramUsers',
        Settings::class => 'App\Http\Sections\Settings',
        Subscription::class => 'App\Http\Sections\Subscription'
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}
