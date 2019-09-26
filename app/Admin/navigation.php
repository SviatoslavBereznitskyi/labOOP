<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    (new Page(\App\Models\User::class))
        ->setIcon('fa fa-money')
        ->setPriority(1),
    (new Page(\App\Models\TelegramUser::class))
        ->setIcon('fa fa-money')
        ->setPriority(2),
    (new Page(\App\Models\Settings::class))
        ->setIcon('fa fa-money')
        ->setPriority(3),
];