<?php

use App\TelegramCommands\InlineCommands;

return[
    InlineCommands::SUBSCRIBE_COMMAND           => 'Підписатися',
    InlineCommands::UNSUBSCRIBE_COMMAND         => 'Відписатися',
    InlineCommands::CHANGE_FREQUENCY_COMMAND    => 'Частота сповіщень',
    InlineCommands::SUBSCRIPTIONS_GET_ALL       => 'Мої підписки',
    'action'                          => [
        InlineCommands::ADD_ACTION            => 'Add channel',
        InlineCommands::SUBSCRIBE_ACTION      => 'Subscribe',
        InlineCommands::UNSUBSCRIBE_ACTION    => 'Unsubscribe',
    ],
];