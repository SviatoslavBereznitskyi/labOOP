<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings', Settings::getSettings()->toArray());
    }

    public function store(Request $request)
    {
        Settings::query()->whereNotNull('key')->delete();
        foreach ($request->except('_token') as $key => $value){
            (new Settings(['key'=>$key, 'value'=>$value]))->save();
        }

        return redirect()->back();
    }

    public function setWebhook(Request $request)
    {
        $uri = $request->get('uri');
       $r = Telegram::setWebhook($uri . '/' . Telegram::getAccessToken());
        return redirect()->back()->with('status', $r);
    }

    public function sendTelegramData($route = '', $params = [], $method = 'POST')
    {

    }
}
