<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TelegramUserRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface TelegramUserRepository extends RepositoryInterface
{
    public function findOrFail($id, $columns = ['*']);
}
