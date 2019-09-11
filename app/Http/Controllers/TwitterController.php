<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;
use Telegram;
use Twitter;

class TwitterController extends Controller
{
    public function test()
    {
        $telegramUsers = TelegramUser::with('subscriptions')->get();
        foreach ($telegramUsers as $user){
            foreach ($user->subscriptions()->where('service','twitter')->get() as $subscription){

                foreach ($subscription->keywords as $keyword){
                    $query = [
                        'q'=>$keyword,
                        'fromDate'=>Carbon::now(),
                        'toDate'=>Carbon::now()
                    ];
                    Telegram::sendMessage([
                        'chat_id' => $user->getKey(),
                        'text' => Twitter::getSearch($query)->statuses[0]->text,]);
                }

            }
        }
        dd('success');
        return;
    }

    public function callback()
    {
        if (Session::has('oauth_request_token'))
        {
            $request_token = [
                'token'  => Session::get('oauth_request_token'),
                'secret' => Session::get('oauth_request_token_secret'),
            ];

            Twitter::reconfig($request_token);

            $oauth_verifier = false;

            if (Input::has('oauth_verifier'))
            {
                $oauth_verifier = Input::get('oauth_verifier');
                // getAccessToken() will reset the token for you
                $token = Twitter::getAccessToken($oauth_verifier);
            }

            if (!isset($token['oauth_token_secret']))
            {
                return Redirect::route('twitter.error')->with('flash_error', 'We could not log you in on Twitter.');
            }

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && !isset($credentials->error))
            {
                // $credentials contains the Twitter user object with all the info about the user.
                // Add here your own user logic, store profiles, create new users on your tables...you name it!
                // Typically you'll want to store at least, user id, name and access tokens
                // if you want to be able to call the API on behalf of your users.

                // This is also the moment to log in your users if you're using Laravel's Auth class
                // Auth::login($user) should do the trick.

                Session::put('access_token', $token);

                return Redirect::to('/')->with('flash_notice', 'Congrats! You\'ve successfully signed in!');
            }

            return Redirect::route('twitter.error')->with('flash_error', 'Crab! Something went wrong while signing you up!');
        }
    }
}
