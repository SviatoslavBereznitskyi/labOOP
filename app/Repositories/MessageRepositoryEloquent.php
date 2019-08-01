<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\MessageRepository;
use App\Models\Message;
use App\Validators\MessageValidator;

/**
 * Class MessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MessageRepositoryEloquent extends BaseRepository implements MessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
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
     * @return Message
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function findByUserOrCreate($userId)
    {
        /** @var Message $entity */
        $entity = $this->findByField(Message::TELEGRAM_USER_ID_FIELD, $userId)->first();

        if($entity){
            return $entity;
        }

        /** @var Message $entity */
        $entity = $this->create([
            Message::TELEGRAM_USER_ID_FIELD => $userId,
            Message::MESSAGE_FIELD => ''
        ]);

        return $entity;
    }
}
