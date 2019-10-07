<?php

use App\TelegramCommands\InlineCommands;

return[
    InlineCommands::SUBSCRIBE_COMMAND           => 'Подписаться',
    InlineCommands::UNSUBSCRIBE_COMMAND         => 'Отписаться',
    InlineCommands::CHANGE_FREQUENCY_COMMAND    => 'Частота оповещений',
    InlineCommands::SUBSCRIPTIONS_GET_ALL       => 'Мои подписки',
    InlineCommands::CHANNELS_COMMAND            => 'Групы',
    'action'                          => [
        InlineCommands::ADD_ACTION            => 'Добавить канал',
        InlineCommands::SUBSCRIBE_ACTION      => 'Подписаться',
        InlineCommands::UNSUBSCRIBE_ACTION    => 'Отписаться',
    ],
];