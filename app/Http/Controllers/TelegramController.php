<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class TelegramController extends Controller
{
    public function sendHello()
    {
        $updates = Telegram::getUpdates();

        dd($updates);

        Telegram::sendMessage([
            'chat_id' => '403811720',
            'text' => 'Hello world!'
        ]);
        return;
    }
}
