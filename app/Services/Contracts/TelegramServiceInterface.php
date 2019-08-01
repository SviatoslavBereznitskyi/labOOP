<?php


namespace App\Services\Contracts;


interface TelegramServiceInterface
{
    public function getEventInstance($name, array $parameters = []);

    public function findOrCreateUser(array $parameters = []);
}