<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Services\Contracts\MailingServiceInterface;

class DashboardController extends Controller
{
    public function index()
    {
        return AdminSection::view(view('admin.dashboard'), trans('admin.dashboard.title'));
    }

    public function sendMessages(MailingServiceInterface $mailingService)
    {
        $mailingService->sendSubscription();

        return redirect()->back();
    }
}
