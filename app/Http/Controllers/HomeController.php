<?php

namespace App\Http\Controllers;


use App\Console\Commands\Bot\TelegramTrait;

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
        $madeline =$this->getMadelineInstance();
        //$madeline->phone_login('+380984721648');

//        $code = readline('Enter the code: ');
//
     //   $madeline->complete_phone_login('60529');

        $messages = $madeline->messages->searchGlobal(['q' => 'laravel',
            'offset_rate' => 0,
            'offset_id' => 0,
            'limit' => 199,]);

        dd($messages);

        return view('home');
    }
}
