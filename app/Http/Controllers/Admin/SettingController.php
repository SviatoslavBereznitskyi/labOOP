<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Models\Settings;
use App\Http\Controllers\Controller;
use Telegram;

class SettingController extends Controller
{
    public function store(SettingRequest $request)
    {
        Settings::query()->whereNotNull('key')->delete();

        foreach ($request->except('_token') as $key => $value) {
            (new Settings(['key' => $key, 'value' => $value]))->save();
        }

        Telegram::setWebhook(['url'=>$request->get('url_callback_bot') . '/' . Telegram::getAccessToken()]);

        return redirect()->back();
    }

    public function setWebhook(SettingRequest $request)
    {
        $uri = $request->get('uri');
        Telegram::setWebhook(['url'=>$uri . '/' . Telegram::getAccessToken()]);
        return redirect()->back()->with('status', Telegram::getWebhookInfo());
    }

    public function sendTelegramData($route = '', $params = [], $method = 'POST')
    {

    }
}
