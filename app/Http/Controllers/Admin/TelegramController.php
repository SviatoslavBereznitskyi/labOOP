<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Console\Commands\Bot\TelegramTrait;
use App\Http\Requests\TelegramConfirmLoginRequest;
use App\Http\Requests\TelegramLoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TelegramController extends Controller
{
    use TelegramTrait;

    public function login()
    {
        return AdminSection::view(view('admin.telegram.phoneLogin'));
    }


    public function logout(Request $request)
    {
        $madeline = $this->getMadelineInstance();

        $madeline->logout();

        return redirect()->back();
    }

    public function phoneLogin(TelegramLoginRequest $request)
    {

        $madeline = $this->getMadelineInstance();

        $madeline->phone_login($request->get('phone'));

        return AdminSection::view(view('admin.telegram.completeLogin'));
    }

    public function completePhoneLogin(TelegramConfirmLoginRequest $request)
    {
        $madeline = $this->getMadelineInstance();

        $madeline->complete_phone_login($request->get('code'));

        return redirect()->route('admin.dashboard');
    }
}
