<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TelegramUserRepository;
use App\TelegramCommands\HelpCommand;
use Illuminate\Http\Request;
use Telegram;

class TelegramController extends Controller
{

   public function  commands(Request $request, TelegramUserRepository $telegramUserRepository)
   {
       $telegram = Telegram::getWebhookUpdates();
       $message = $telegram['message'];
       if(!$telegramUserRepository->find($message['from']['id'])){
           $telegramUserRepository->create($message['from']);
       }
       Telegram::commandsHandler(true);
       if(!key_exists('entities', $message)){

       }

   }
}
