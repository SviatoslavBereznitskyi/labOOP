<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Subscription.
 *
 * @package namespace App\Models;
 */
class Subscription extends Model implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class);
    }

}
