<?php

namespace App\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\SentMessagesRepository;
use App\Models\SentMessages;
use App\Validators\SentMessagesValidator;

/**
 * Class SentMessagesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SentMessagesRepositoryEloquent extends BaseRepository implements SentMessagesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SentMessages::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function deleteOld()
    {
        \DB::beginTransaction();

        SentMessages::query()->whereDate('created_at', '<', Carbon::now()->subWeek())->delete();

        \DB::commit();
    }
}
