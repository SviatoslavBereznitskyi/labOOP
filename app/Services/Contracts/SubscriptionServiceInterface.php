<?php


namespace App\Services\Contracts;


use App\Models\Subscription;

interface SubscriptionServiceInterface
{
    public function updateOrCreate(array $params);

    /**
     * @param int $userId
     * @param string $service
     * @return Subscription
     */
    public function getByUserAndService(int $userId, string $service);

    public function update($params, $id);

    public function getKeywords(int $id);

    public function getKeywordsForKeyboard(int $id);
}