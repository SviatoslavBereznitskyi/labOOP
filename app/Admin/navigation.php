<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    [
        'title' => trans('admin.dashboard.title'),
        'icon' => 'fa fa-dashboard',
        'url' => route('admin.dashboard'),
        'priority' => 0
    ],
    (new Page(\App\Models\User::class))
        ->setIcon('fa fa-user')
        ->setPriority(1),
    (new Page(\App\Models\TelegramUser::class))
        ->setIcon('fa fa-users')
        ->setPriority(2),
    (new Page(\App\Models\Settings::class))
        ->setIcon('fa fa-cog')
        ->setPriority(4),
    (new Page(\App\Models\Subscription::class))
        ->setIcon('fa fa-envelope')
        ->setPriority(3),
    (new Page(\App\Models\Channels::class))
        ->setIcon('fa fa-envelope')
        ->setPriority(5),

];