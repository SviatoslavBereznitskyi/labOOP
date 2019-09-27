<?php

use SleepingOwl\Admin\Navigation\Page;

return [
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
];