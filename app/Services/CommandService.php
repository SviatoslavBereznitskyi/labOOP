<?php


namespace App\Services;

use App\Models\InlineCommand;
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
            InlineCommand::MODEL_FIELD          => null,
            InlineCommand::MODEL_ID_FIELD       => null,
            InlineCommand::KEYBOARD_EVENT_FIELD => $command,
        ];

        if ($model) {
            $data = [
                InlineCommand::MODEL_FIELD          => get_class($model),
                InlineCommand::MODEL_ID_FIELD       => $model->getKey(),
                InlineCommand::KEYBOARD_EVENT_FIELD => $command,
            ];
        }

        $this->commandRepository->update($data, $messageId);
    }
}