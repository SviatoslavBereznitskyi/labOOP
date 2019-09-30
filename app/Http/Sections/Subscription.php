<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Display\Column\Editable\EditableColumn;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

/**
 * Class Subscription
 *
 * @property \App\Models\Subscription $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Subscription extends Section implements Initializable
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

    /**
     * Initialize class.
     */
    public function initialize()
    {
    }

    public function getTitle()
    {
        return trans('admin.subscriptions.title');
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
                AdminColumn::text('telegramUser.first_name', trans('admin.subscriptions.firstName')),
                AdminColumn::text('telegramUser.username', trans('admin.subscriptions.username')),
                AdminColumn::lists('keywords', trans('admin.subscriptions.keywords'))->setWidth('50%'),
                AdminColumn::text('service', trans('admin.subscriptions.service'))
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
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Name')->required(),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    public function  isEditable(Model $model)
    {
        return false;
    }

    public function isDeletable(Model $model)
    {
        return true;
    }

}
