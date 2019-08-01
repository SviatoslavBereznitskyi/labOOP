<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Message.
 *
 * @property array message
 * @property string|null $keyboard_command
 * @package namespace App\Models;
 */
class Message extends Model implements Transformable
{
    use TransformableTrait;

    //fields list
    const TELEGRAM_USER_ID_FIELD = 'telegram_user_id';
    const MESSAGE_FIELD = 'message';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'message' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(TelegramUser::class);
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setMessage($data)
    {
        $this->message = $data;

        return $this;
    }

    /**
     * @param string|null $command
     * @return $this
     */
    public function setKeyboardCommand(string $command = null)
    {
        $this->keyboard_command = $command;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getKeyboardCommand()
    {
        return $this->keyboard_command;
    }
}
