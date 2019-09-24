<?php


namespace App\Services;

use App\Models\Subscription;
use App\Repositories\Contracts\CommandRepository;
use App\Services\Contracts\CommandServiceInterface;
use Illuminate\Database\Eloquent\Model;

class CommandService implements CommandServiceInterface
{

    /**
     * @var CommandRepository
     */
    private $commandRepository;

    public function __construct(CommandRepository $commandRepository)
    {
        $this->commandRepository = $commandRepository;
    }

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

        $this->commandRepository->update($data, $messageId);
    }
}