<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Command.
 *
 * @property array message
 * @property string|null $keyboard_event
 * @property string|null model_value
 * @property integer|null model_id
 * @property string|null model
 * @property array commands_chain
 * @package namespace App\Models;
 */
class InlineCommand extends Model implements Transformable
{
    use TransformableTrait;

    //fields list
    const TELEGRAM_USER_ID_FIELD = 'telegram_user_id';
    const KEYBOARD_EVENT_FIELD = 'keyboard_event';
    const MODEL_FIELD = 'model';
    const MODEL_ID_FIELD = 'model_id';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'commands_chain' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(TelegramUser::class);
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return int
     */
    public function getModelId()
    {
        return $this->model_id;
    }

    /**
     * @param string|null $command
     * @return $this
     */
    public function setKeyboardEvent(string $command = null)
    {
        $this->keyboard_event = $command;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getKeyboardEvent()
    {
        return $this->keyboard_event;
    }

    /**
     * @param $command
     */
    public function addToCommandsChain($command, $key)
    {
        $commands = $this->commands_cain;
        $commands[$key] = $command;

        $this->commands_chain = $commands;

        return $this;
    }

    /**
     * @return array
     */
    public function getCommandsChain()
    {
        return (array)$this->commands_chain;
    }
}
