<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram;

class TelegramController extends Controller
{
    public function setWebhook(Request $request)
    {
        $uri = $request->get('uri');
         Telegram::setWebhook(['url'=>$uri . '/' . Telegram::getAccessToken()]);
        return redirect()->back()->with('status', Telegram::getWebhookInfo());
    }
}
