<?php

namespace App\Repositories\Contracts;

use App\Models\InlineCommand;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CommandRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CommandRepository extends RepositoryInterface
{
    public function findOrCreateByUser($userId);

    public function addCommand(InlineCommand $inlineCommand, $command, $key);
}
