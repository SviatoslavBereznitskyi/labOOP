<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Accessory;
use App\Models\User;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Users
 *
 * @property \App\Models\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Users extends Section
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
        return trans('admin.admins.title');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-primary');


        $display->setColumns([
            AdminColumn::text('name')
                ->setLabel(trans('admin.admins.name'))
                ->setWidth('400px'),
            AdminColumn::text('email')
                ->setLabel(trans('admin.admins.email'))
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
        $form = AdminForm::panel();
        $form->addBody([
            AdminFormElement::text('name', trans('admin.admins.name'))->required(),
            AdminFormElement::text('email', trans('admin.admins.email'))->required(),
            AdminFormElement::password('password', trans('admin.admins.password')),
        ]);

        return $form;
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
}
