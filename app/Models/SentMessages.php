<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SentMessages.
 *
 * @package namespace App\Models;
 */
class SentMessages extends Model implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class);
    }

}
