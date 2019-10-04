<?php

use App\TelegramCommands\InlineCommands;

return[
    InlineCommands::SUBSCRIBE_COMMAND           => 'Подписаться',
    InlineCommands::UNSUBSCRIBE_COMMAND         => 'Отписаться',
    InlineCommands::CHANGE_FREQUENCY_COMMAND    => 'Частота оповещений',
    InlineCommands::SUBSCRIPTIONS_GET_ALL       => 'Мои подписки',
    InlineCommands::CHANNELS_COMMAND            => 'Channels',
    'action'                          => [
        InlineCommands::ADD_ACTION            => 'Add channel',
        InlineCommands::SUBSCRIBE_ACTION      => 'Subscribe',
        InlineCommands::UNSUBSCRIBE_ACTION    => 'Unsubscribe',
    ],
];