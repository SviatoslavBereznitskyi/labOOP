<?php


namespace App\Services;


use App\Models\Subscription;
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

        if (!$subscription) {
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

    /**
     * @param int $id
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getKeywords(int $id)
    {
        /** @var Subscription $subscription */
        $subscription = $this->subscriptionRepository->find($id);

        $text = trans('answers.input.select_word');

        foreach ($subscription->getKeywords() as $key => $item) {
            $text = $text . PHP_EOL . ($key + 1) . '. ' . $item;
        }

        return $text;
    }

    public function getUserKeywordsList(int $userId, $language)
    {
        $subscriptions = $this->subscriptionRepository->getByUser($userId);

        if($subscriptions->isEmpty()){
            return trans('answers.noSubscriptions');
        }
        $text = '';
        foreach ($subscriptions as $subscription) {
            $text = $text
                . PHP_EOL
                . trans('answers.subscriptions', ['service' => $subscription->getService()], $language)
                . PHP_EOL
                . trans('answers.frequency', ['value' => $subscription->getFrequency()], $language);

            foreach ($subscription->getKeywords() as $item) {
                $text = $text . PHP_EOL  . '- ' . $item;
            }
        }

        return $text;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getKeywordsForKeyboard(int $id)
    {
        /** @var Subscription $subscription */
        $subscription = $this->subscriptionRepository->find($id);

        $text = trans('answers.input.select_word');

        $array = [];
        foreach ($subscription->getKeywords() as $key => $item) {
            $array[] = $item;
        }

        return $array;
    }

    public function delete($id)
    {
        $this->subscriptionRepository->delete($id);
    }
}