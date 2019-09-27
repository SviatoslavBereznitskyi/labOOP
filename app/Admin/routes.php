<?php

Route::get('', ['as' => 'admin.dashboard', 'uses' => \App\Http\Controllers\Admin\DashboardController::class . '@index']);

Route::post('', ['as' => 'admin.dashboard.send', 'uses' => \App\Http\Controllers\Admin\DashboardController::class . '@sendMessages']);