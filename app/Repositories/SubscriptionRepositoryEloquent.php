<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SubscriptioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SubscriptionRepositoryEloquent extends BaseRepository implements SubscriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param int $userId
     * @param string $service
     * @return Subscription|null
     */
    public function getByUserService(int $userId, string $service)
    {
        return Subscription::query()->byUser($userId)->byService($service)->first();
    }

    /**
     * @param int $userId
     * @return Subscription[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getByUser(int $userId)
    {
        return Subscription::query()->byUser($userId)->get();
    }

    /**
     * @param int $frequency
     * @return mixed
     */
    public function whereFrequency(int $frequency)
    {
        return Subscription::query()->byFrequency($frequency)->get();
    }
}
