<?php


namespace App\Services\Contracts;


use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

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

    public function delete($id);

    public function getKeywords(int $id);

    public function getUserKeywordsList(int $telegramUserId);

    public function getKeywordsForKeyboard(int $id);
}