<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ChannelRepository;
use App\Models\Channel;
use App\Validators\ChannelsValidator;

/**
 * Class ChannelsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChannelRepositoryEloquent extends BaseRepository implements ChannelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Channel::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
