<?php


namespace App\Services;

use App\Models\Subscription;
use App\Repositories\Contracts\MessageRepository;
use App\Services\Contracts\CommandServiceInterface;
use Illuminate\Database\Eloquent\Model;

class CommandService implements CommandServiceInterface
{

    public function setCommandMessage( string $command, int $messageId, Model $model = null)
    {

        $data = [
            'model' => null,
            'model_id' => null,
            'keyboard_command' => null,
        ];

        if ($model) {
            $data = [
                'model' => get_class($model),
                'model_id' => $model->getKey(),
                'keyboard_command' => $command,
            ];
        }

        $messageRepository = resolve(MessageRepository::class);

        $messageRepository->update($data, $messageId);
    }
}