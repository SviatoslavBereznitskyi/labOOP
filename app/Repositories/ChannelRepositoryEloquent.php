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

    public function attachUser(Channel $channel, $userId)
    {
        $channel->telegramUsers()->attach($userId);
    }

    public function detachUser(Channel $channel, $userId)
    {
        $channel->telegramUsers()->detach($userId);
    }

    public function findByTitle($title, $service)
    {
        return Channel::query()->where('service', $service)->where('title', 'like', $title . '%')->latest()->first();
    }

    public function findWhereInTitle($titles, $service)
    {
        return Channel::query()
            ->where('service', $service)
            ->where(function ($query) use ($titles) {
                foreach ($titles as $title) {
                    $query->orWhere('title', 'like', $title . '%');
                }
            })
            ->get();
    }

    public function createAndSubscribe($params, $model){
        /** @var Channel $channel */
        $channel = $this->updateOrCreate($params);
        $channel->telegramUsers()->attach(resolve($model)::all());
    }

}
