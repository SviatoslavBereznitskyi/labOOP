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
        return view('home');
    }
}
