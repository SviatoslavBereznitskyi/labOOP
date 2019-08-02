<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Model;

interface CommandServiceInterface
{
    public function setCommandMessage(string $command, int $messageId, Model $model = null);
}