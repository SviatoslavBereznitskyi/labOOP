<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CommandRepository;
use App\Models\InlineCommand;
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
        return InlineCommand::class;
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
     * @return InlineCommand
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function findByUserOrCreate($userId)
    {
        /** @var InlineCommand $entity */
        $entity = $this->findByField(InlineCommand::TELEGRAM_USER_ID_FIELD, $userId)->first();

        if($entity){
            return $entity;
        }

        /** @var InlineCommand $entity */
        $entity = $this->create([
            InlineCommand::TELEGRAM_USER_ID_FIELD => $userId,
        ]);

        return $entity;
    }
}
