<?php

use App\TelegramCommands\InlineCommands;

return[
    InlineCommands::SUBSCRIBE_COMMAND           => 'Subscribe',
    InlineCommands::UNSUBSCRIBE_COMMAND         => 'Unsubscribe',
    InlineCommands::CHANGE_FREQUENCY_COMMAND    => 'Frequency',
    InlineCommands::SUBSCRIPTIONS_GET_ALL       => 'My subscriptions',
    InlineCommands::CHANNELS_COMMAND            => 'Channels',
    'action'                          => [
        InlineCommands::ADD_ACTION            => 'Add channel',
        InlineCommands::SUBSCRIBE_ACTION      => 'Subscribe',
        InlineCommands::UNSUBSCRIBE_ACTION    => 'Unsubscribe',
    ],
];