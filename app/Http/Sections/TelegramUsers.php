<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class TelegramUsers
 *
 * @property \App\Models\TelegramUser $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class TelegramUsers extends Section
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
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync();


        $display->setColumns([
            AdminColumn::text('first_name')
                ->setLabel(trans('user.first_name'))
                ->setWidth('400px'),
            AdminColumn::text('last_name')
                ->setLabel(trans('user.last_name'))
                ->setWidth('400px'),
            AdminColumn::text('username')
                ->setLabel(trans('user.username'))
                ->setWidth('400px'),
            AdminColumn::text('is_bot')
                ->setLabel(trans('user.is_bot'))
                ->setWidth('400px'),
            AdminColumn::text('language_code')
                ->setLabel(trans('user.language_code'))
                ->setWidth('400px'),
        ]);

        $display->setDisplaySearch(true);

        $display->paginate(15);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        // remove if unused
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    public function isEditable(Model $model)
    {
        return false;
    }
}
