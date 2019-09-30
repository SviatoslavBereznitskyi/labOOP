<?php


namespace App\Services\Contracts;


interface MailingServiceInterface
{
    public function sendSubscription($frequency = null);
}