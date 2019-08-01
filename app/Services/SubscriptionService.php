<?php


namespace App\Services;


use App\Repositories\Contracts\SubscriptionRepository;
use App\Services\Contracts\SubscriptionServiceInterface;

class SubscriptionService implements SubscriptionServiceInterface
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @param array $params
     * @return \App\Models\Subscription|null
     */
    public function updateOrCreate(array $params)
    {
        $subscription = $this->subscriptionRepository->getByUserService($params['telegram_user_id'], $params['service']);

        if(!$subscription){
            $this->subscriptionRepository->create($params);
            return $this->subscriptionRepository->getByUserService($params['telegram_user_id'], $params['service']);
        }

        $this->subscriptionRepository->update($params, $subscription->getKey());

        return $this->subscriptionRepository->getByUserService($params['telegram_user_id'], $params['service']);
    }

    /**
     * @param $params
     * @param $id
     */
    public function update($params, $id)
    {
        $this->subscriptionRepository->update($params, $id);
    }

    /**
     * @param int $userId
     * @param string $service
     * @return \App\Models\Subscription|null
     */
    public function getByUserAndService(int $userId, string $service)
    {
        return $this->subscriptionRepository->getByUserService($userId, $service);
    }
}