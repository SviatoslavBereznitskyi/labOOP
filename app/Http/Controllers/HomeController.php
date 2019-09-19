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
        dd(env('TWITTER_CONSUMER_KEY'));
        $MadelineProto = new API('session.madeline', config('mdproto'));
        $MadelineProto->phone_login('+380984721648');
        $authorization =  $MadelineProto->complete_phone_login(14097);
        return view('home');
    }

    public function auth()
    {

        return view('home');
    }
}
