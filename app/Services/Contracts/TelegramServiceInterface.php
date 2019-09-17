<?php


namespace App\Services\Contracts;


interface TelegramServiceInterface
{
    public function getEventInstance($name, array $parameters = []);

    public function findOrCreateUser(array $parameters = []);

    public function forwardMessage($messageId, $userId, $fromChatId);

    public function processMessages($messageId, $chatId);
}