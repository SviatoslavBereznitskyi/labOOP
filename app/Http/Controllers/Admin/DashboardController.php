<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Console\Commands\Bot\TelegramTrait;
use App\Http\Controllers\Controller;
use App\Services\Contracts\MailingServiceInterface;

class DashboardController extends Controller
{
    use TelegramTrait;

    public function index()
    {
        $madeline = $this->getMadelineInstance();

        $user = null;

        if($madeline->get_self())
        {
            $madeline->channels->joinChannel(['channel' => 'https://telegram.me/jobsinkenya', ]);
            dd($madeline->messages->getAllChats(['offset' => 0, ]));
            $user = $this->parseUser($madeline->get_self());
        }

        return AdminSection::view(view('admin.dashboard')->with(['user'=>$user]), trans('admin.dashboard.title'));
    }


    private function parseUser(array $user)
    {
        $firstName = key_exists('first_name', $user) ? $user['first_name'] : ' ';
        $username = key_exists('username', $user) ? $user['username'] : ' ';
        $lastName = key_exists('last_name', $user) ? $user['last_name'] : ' ';
        $phone = key_exists('phone', $user) ? $user['phone'] : ' ';

        return [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'username'  => $username,
            'phone'     => $phone,
        ];
    }

    public function sendMessages(MailingServiceInterface $mailingService)
    {
        $mailingService->sendSubscription();

        return redirect()->back();
    }
}
