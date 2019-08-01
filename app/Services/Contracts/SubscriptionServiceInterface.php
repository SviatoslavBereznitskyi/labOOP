<?php


namespace App\Services\Contracts;


interface SubscriptionServiceInterface
{
    public function updateOrCreate(array $params);

    public function getByUserAndService(int $userId, string $service);

    public function update($params, $id);
}