<?php

class ReportsController extends BackEndController
{
    private $_model_name = 'FormRequest';
    private $_e_404_message = 'Запрашиваемая страница не найдена.';

    public function actions()
    {
        return array(
            'index' => array(
                'class' => 'IndexAction',
                'model_name' => $this->_model_name,
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'roles' => array(User::ROLE_GLOBAL_ADMIN, User::ROLE_GLOBAL_MANAGER),
            ),
            array('deny',
                'users' => array('?'),
            ),
        );
    }
}