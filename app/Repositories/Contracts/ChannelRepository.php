<?php

namespace App\Repositories\Contracts;

use App\Models\Channel;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ChannelsRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface ChannelRepository extends RepositoryInterface
{
    public function attachUser(Channel $channel, $userId);

    public function detachUser(Channel $channel, $userId);

    /**
     * @param $title
     * @param $service
     * @return Channel|null
     */
    public function findByTitle($title, $service);

    /**
     * @param $titles
     * @param $service
     * @return mixed
     */
    public function findWhereInTitle($titles, $service);

    public function createAndSubscribe($params, $model);
}
