<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Models\TelegramUser;
use App\Validators\TelegramUserValidator;

/**
 * Class TelegramUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TelegramUserRepositoryEloquent extends BaseRepository implements TelegramUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TelegramUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->find($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findOrFail($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function getActiveUsers()
    {
        return TelegramUser::query()->with(['sentMessages', 'channels'])->where('subscription', true)->get();
    }
}
