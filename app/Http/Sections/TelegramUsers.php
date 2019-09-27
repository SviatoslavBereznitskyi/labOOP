<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use App\Models\TelegramUser;
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

    public function getTitle()
    {
        return trans('admin.tgUsers.title');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $types = TelegramUser::getTypesFields();

        $tabs = [];
        foreach ($types as $key => $type) {
            $tab = AdminDisplay::datatablesAsync();
            $columns = [];
            foreach ($type['fields'] as $field) {
                $columns[] = AdminColumn::text($field)
                    ->setLabel(trans('admin.tgUsers.' . $field))
                    ->setWidth('400px');
            }
            $columns[] = AdminColumnEditable::checkbox('subscription')
                ->setLabel(trans('admin.tgUsers.subscription'));

            $tab->setColumns($columns);

            $tab->setDisplaySearch(true);

            $tab->getColumns()->disableControls();

            $tab->setScopes(['byType', $key]);

            $tab->paginate(15);

            $tab->setName($type['name']);

            $tabs [] = AdminDisplay::tab($tab, $type['name']);
        }

        return AdminDisplay::tabbed()->setTabs($tabs);
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
        return true;
    }
}
