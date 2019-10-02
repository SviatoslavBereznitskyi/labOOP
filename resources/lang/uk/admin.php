<?php

use App\Models\TelegramUser;

return [
    'subscriptions' => [
        'title' => 'Підписки',
        'keywords'  => 'Ключові слова',
        'service'   => 'Сервіс',
        'firstName' => 'Ім\'я користувача',
        'username'  => 'Username',
        'frequency' => 'Частота',
    ],
    'admins' => [
        'title' => 'Адміністратори',
        'name'  => 'Ім\'я',
        'email' => 'Email',
    ],
    'tgUsers' => [
        'title'                     => 'Користувачі Telegram',
        'first_name'                => 'Ім\'я',
        'last_name'                 => 'Прізвище',
        'username'                  => 'Username',
        'is_bot'                    => 'Бот',
        'language_code'             => 'Мова',
        'subscription'              => 'Активна підписка',
        TelegramUser::TYPE_GROUP    => 'Групи',
        TelegramUser::TYPE_PRIVATE  => 'Приватні чати',
    ],
    'settings' => [
        'title' => 'Налаштування',
        'uriTitle' => 'Url callback для Telegram Bot',
        'action' => 'Дія',
        'insertUri' => 'Вставити URI',
        'sendUri' => 'Відправити URI',
        'save' => 'Зберегти',
    ],
    'dashboard' => [
        'title'         => 'Панель приладів',
        'send_label'    => 'Send ALL subscriptions messages to ALL users',
        'send'          => 'GO!',
    ],
];