<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CommandRepository;
use App\Models\Command;
use App\Validators\MessageValidator;

/**
 * Class CommandRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CommandRepositoryEloquent extends BaseRepository implements CommandRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Command::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $userId
     * @return Command
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function findByUserOrCreate($userId)
    {
        /** @var Command $entity */
        $entity = $this->findByField(Command::TELEGRAM_USER_ID_FIELD, $userId)->first();

        if($entity){
            return $entity;
        }

        /** @var Command $entity */
        $entity = $this->create([
            Command::TELEGRAM_USER_ID_FIELD => $userId,
        ]);

        return $entity;
    }
}
