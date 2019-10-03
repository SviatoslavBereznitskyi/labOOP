<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ChannelsRepository;
use App\Models\Channels;
use App\Validators\ChannelsValidator;

/**
 * Class ChannelsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChannelsRepositoryEloquent extends BaseRepository implements ChannelsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Channels::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
