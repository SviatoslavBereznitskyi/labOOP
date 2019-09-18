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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $madelineProto = new \danog\MadelineProto\API('session.madeline');


        $messages = $madelineProto->messages->getHistory([
            /* Название канала, без @ */
            'peer' => 'chatname',
            'offset_id' => 0,
            'offset_date' => 0,
            'add_offset' => 0,
            'limit' => 20,
            'max_id' => 9999999,
            /* ID сообщения, с которого начинаем поиск */
            'min_id' => 12000,
        ]);


        dd($messages);
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
