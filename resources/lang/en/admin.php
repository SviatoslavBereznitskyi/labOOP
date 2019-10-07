<?php

use App\Models\TelegramUser;

return [
    'subscriptions' => [
        'title' => 'Subscriptions',
        'keywords'  => 'Keywords',
        'service'   => 'Service',
        'firstName' => 'User first name',
        'username'  => 'Username',
        'frequency' => 'Frequency',
    ],
    'admins' => [
        'title' => 'Admins',
        'name'  => 'Name',
        'email' => 'Email',
    ],
    'tgUsers' => [
        'title'                     => 'Telegram Users',
        'first_name'                => 'First name',
        'last_name'                 => 'Last name',
        'username'                  => 'Username',
        'is_bot'                    => 'Is bot',
        'language_code'             => 'Language',
        'subscription'              => 'Active subs.',
        'phone'                     => 'Phone',
        TelegramUser::TYPE_GROUP    => 'Groups',
        TelegramUser::TYPE_PRIVATE  => 'Users',
    ],
    'settings' => [
        'title'     => 'Settings',
        'uriTitle'  => 'Url callback for Telegram Bot',
        'action'    => 'Action',
        'insertUri' => 'Insert URI',
        'sendUri'   => 'Send URI',
        'save'      => 'Save',
    ],
    'dashboard' => [
        'title'         => 'Dashboard',
        'send_label'    => 'Send ALL subscriptions messages to ALL users',
        'send'          => 'GO!',
    ],
    'channels' => [
        'title'         => 'Channels',
    ],

];