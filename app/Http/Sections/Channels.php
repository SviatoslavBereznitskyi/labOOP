<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Channel;
use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

/**
 * Class Channels
 *
 * @property Channel $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Channels extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    public function getTitle()
    {
        return trans('admin.channels.title');
    }

    /**
     * Initialize class.
     */
    public function initialize()
    {

    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        return AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('title', 'Name'),
                AdminColumn::text('username', 'Username'),
                AdminColumn::text('service', 'Service'),
                AdminColumn::text('is_personal', 'Is personal')
            )
            ->setOrder([1, 'ASC'])
            ->paginate(20)
        ;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $this->model->created(function ($model) {
            $model->telegramUsers()->attach(TelegramUser::all());
        });

        return AdminForm::panel()->addBody([
            AdminFormElement::text('username', 'Channel name')->required(),
            AdminFormElement::select('service', 'Service')->setEnum(\App\Models\Subscription::getGroupServices())->required(),
        ]);


    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    public function isEditable(Model $model)
    {
        return false;
    }
}
