<?php

class BaseWebApplication extends CWebApplication
{
    public function init()
    {
        parent::init();

        $this->_importModulesDirectories();
    }

    protected function _importModulesDirectories()
    {
        $modules = $this->getModulesNames();

        foreach ($modules as $module) {
            Yii::import('application.modules.' . $module . '.*');
            Yii::import('application.modules.' . $module . '.models.*');
            Yii::import('application.modules.' . $module . '.components.*');
            Yii::import('application.modules.' . $module . '.components.controllers.*');
            Yii::import('application.modules.' . $module . '.components.custom.*');
            Yii::import('application.modules.' . $module . '.components.widgets.*');
            Yii::import('application.modules.' . $module . '.behaviors.*');
            Yii::import('application.modules.' . $module . '.helpers.*');
        }
    }

    public function getModulesNames()
    {
        $modules = array();

        $modules_dump = Yii::app()->modules;
        foreach ($modules_dump as $module_dump) {
            $module_array = explode('.', $module_dump['class']);
            $module = $module_array[0];

            if ($module == 'system') {
                continue;
            }

            $modules[] = $module;
        }

        return $modules;
    }
}