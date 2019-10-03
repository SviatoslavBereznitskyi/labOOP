<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Console\Commands\Bot\TelegramTrait;
use App\Models\Subscription;
use App\Repositories\Contracts\ChannelsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TelegramGroupController extends Controller
{
    use TelegramTrait;

    public function sync(Request $request, ChannelsRepository $channelsRepository)
    {
        set_time_limit(120);

        $madeline = $this->getMadelineInstance();

        $chats = $madeline->messages->getAllChats();

        $chats = array_filter($chats['chats'], function ($chat) {
            return $chat['_'] == 'channel';
        });

        foreach ($chats as $chat){
            $channelsRepository->updateOrCreate([
                'channel_id' => $chat['id'],
                'title' => $chat['title'],
                'service' => Subscription::TELEGRAM_SERVICE,
                'username' => $chat['username'],
            ]);
        }

         return redirect()->back();
    }
}
