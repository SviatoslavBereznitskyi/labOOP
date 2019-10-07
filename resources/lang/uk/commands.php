<?php

use App\TelegramCommands\InlineCommands;

return[
    InlineCommands::SUBSCRIBE_COMMAND           => 'Підписатися',
    InlineCommands::UNSUBSCRIBE_COMMAND         => 'Відписатися',
    InlineCommands::CHANGE_FREQUENCY_COMMAND    => 'Частота сповіщень',
    InlineCommands::SUBSCRIPTIONS_GET_ALL       => 'Мої підписки',
    InlineCommands::CHANNELS_COMMAND            => 'Групи',
    'action'                          => [
        InlineCommands::ADD_ACTION            => 'Додати канал',
        InlineCommands::SUBSCRIBE_ACTION      => 'Підписатися',
        InlineCommands::UNSUBSCRIBE_ACTION    => 'Відписатися',
    ],
];