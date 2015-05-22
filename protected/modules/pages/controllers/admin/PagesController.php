<?php

class PagesController extends BackEndController
{
    private $_model_name = 'Page';
    private $_e_404_message = 'Запрашиваемая страница не найдена.';

    public function actions()
    {
        return array(
            'delete' => array(
                'class' => 'DeleteAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Страница удалена!',
                'error_message' => 'Страница не удалена!',
                'e_404_message' => $this->_e_404_message,
            ),
            'create' => array(
                'class' => 'CreateAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Страница успешно создана!',
                'error_message' => 'Не удалось создать страницу!',
            ),
            'update' => array(
                'class' => 'UpdateAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Страница успешно изменена!',
                'error_message' => 'Не удалось изменить страницу!',
                'e_404_message' => $this->_e_404_message,
            ),
            'index' => array(
                'class' => 'IndexAction',
                'model_name' => $this->_model_name,
            ),
            'turnOn' => array(
                'class' => 'TurnOnAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Страница успешно включена!',
                'error_message' => 'Не удалось включить страницу!',
                'e_404_message' => $this->_e_404_message,
            ),
            'turnOff' => array(
                'class' => 'TurnOffAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Страница успешно выключена!',
                'error_message' => 'Не удалось выключить страницу!',
                'e_404_message' => $this->_e_404_message,
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('create', 'index', 'update', 'delete', 'turnOn', 'turnOff'),
                'roles' => array(User::ROLE_GLOBAL_ADMIN, User::ROLE_GLOBAL_MANAGER),
            ),
            array('deny',
                'users' => array('?'),
            ),
        );
    }
}