<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TelegramUser
 *
 * @property string|null first_name
 * @property string|null last_name
 * @property string|null username
 * @property string|null language_code
 * @property bool subscription
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property int $is_bot
 * @property string|null $type
 * @property string|null $title
 * @property int|null $all_members_are_administrators
 * @property string $language_code
 * @property int $subscription
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Command $lastMessage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SentMessages[] $sentMessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser byType($type)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereAllMembersAreAdministrators($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereIsBot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TelegramUser whereUsername($value)
 */
	class TelegramUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settings
 *
 * @property string $key
 * @property string $value
 * @property int $serialized
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereSerialized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereValue($value)
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Command.
 *
 * @property array message
 * @property string|null $keyboard_command
 * @property string|null model_value
 * @property integer|null model_id
 * @property string|null model
 * @package namespace App\Models;
 * @property int $id
 * @property string|null $model
 * @property int|null $model_id
 * @property int $telegram_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TelegramUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereKeyboardCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereTelegramUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Command whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SentMessages.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property int $telegram_user_id
 * @property string $post_id
 * @property string $service
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TelegramUser $telegramUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages whereTelegramUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SentMessages whereUpdatedAt($value)
 */
	class SentMessages extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Subscription.
 *
 * @property array keywords
 * @package namespace App\Models;
 * @property int $id
 * @property array|null $keywords
 * @property int $frequency
 * @property int $telegram_user_id
 * @property string $service
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TelegramUser $telegramUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription byService($service)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereTelegramUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

