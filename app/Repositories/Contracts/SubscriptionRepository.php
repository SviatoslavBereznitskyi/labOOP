<?php

namespace App\Repositories\Contracts;

use App\Models\Subscription;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SubscriptionRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface SubscriptionRepository extends RepositoryInterface
{
    /**
     * @param int $userId
     * @param string $service
     * @return Subscription|null
     */
    public function getByUserService(int $userId, string $service);
}
