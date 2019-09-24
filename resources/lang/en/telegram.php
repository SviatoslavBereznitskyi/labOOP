<?php
return [
    'users'=>[
        \App\Models\TelegramUser::TYPE_GROUP    => 'Groups',
        \App\Models\TelegramUser::TYPE_PRIVATE  => 'Users',
    ],
];