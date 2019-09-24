<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->namespace('Admin')
    ->name('admin.')
    ->group(function () {
        Route::post('/settings', SettingController::class . '@store')->name('settings.store');
        Route::post('/settings/webhook', SettingController::class . '@setWebhook')->name('setting.webhook');
    });

Route::post(Telegram::getAccessToken(), TelegramController::class . '@commands')->name('telegram.commands');

Auth::routes();

Route::match(['post', 'get'], 'register', function () {
    Auth::logout();
    return redirect('/');
})->name('register');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');

Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');

Route::group(['middleware' => [
    'auth'
]], function () {
    Route::get('/user', 'GraphController@retrieveUserProfile');
    Route::post('/user', 'GraphController@publishToProfile');
    Route::post('/page', 'GraphController@publishToPage');
});

Route::get('twitter/test', TwitterController::class.'@test');
Route::get('twitter/callback', TwitterController::class.'@callback')->name('twitter.callback');
Route::get('/homeTimeline', function()
{
    $fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
    try {
        $response = $fb->get('/search/posts/?q=фвфів', 'user-access-token');
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    $userNode = $response->getGraphUser();
    printf('Hello, %s!', $userNode->getName());
});

Route::get('/twitter/get', function()
{
    Artisan::call('send:messages');
    return 'success';
});


