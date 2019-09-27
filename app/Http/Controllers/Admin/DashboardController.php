<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return AdminSection::view(view('admin.dashboard'), trans('admin.dashboard.title'));
    }

    public function sendMessages()
    {
        \Artisan::call('send:messages');
        return redirect()->back();
    }
}
