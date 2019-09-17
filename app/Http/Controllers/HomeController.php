<?php

namespace App\Http\Controllers;

use danog\MadelineProto\API;
use danog\MadelineProto\MyTelegramOrgWrapper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        set_time_limit(30);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $MadelineProto = new \danog\MadelineProto\API('session.madeline');
        //$MadelineProto->start();

        $messages_Messages = $MadelineProto->messages->getHistory([
            'peer' => 'https://t.me/joinchat/AAAAAFY7Rrgkw2Ro8Uo44w',
            'limit' => 25,
        ]);
        return view('home');
    }

    public function auth()
    {
        $MadelineProto = new API('session.madeline', config('mdproto'));
        $MadelineProto->phone_login('+380984721648');
        $authorization =  $MadelineProto->complete_phone_login(65237);
        return view('home');
    }
}
