<?php

namespace App\Http\Controllers;


use App\Console\Commands\Bot\TelegramTrait;
use App\Models\InlineCommand;
use App\Models\TelegramUser;
use App\Services\Subscriptions\UpworkSubscriptionsService;
use App\TelegramCommands\InlineCommands;
use Upwork\API\Utils as ApiUtils;

class HomeController extends Controller
{
    /**
     * @var UpworkSubscriptionsService
     */
    private $upworkSubscriptionsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->upworkSubscriptionsService = new UpworkSubscriptionsService(TelegramUser::query()->first(), 60);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $oauth = new \OAuth(
//            config('upwork.client.consumerKey'),
//            config('upwork.client.consumerSecret'),
//            'HMAC-SHA1',
//            2
//        );
//        $requestTokenInfo = $oauth->getRequestToken(
//            'https://www.upwork.com/api/auth/v1/oauth/token/access'
//        );
//        dd($requestTokenInfo);
        dd($this->upworkSubscriptionsService->getPosts());

        return view('home');
    }
}
