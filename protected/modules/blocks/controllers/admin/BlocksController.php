<?php

class BlocksController extends BackEndController
{
    private $_model_name = 'Block';
    private $_e_404_message = 'Запрашиваемый блок не найден.';

    public function actions()
    {
        return array(
            'delete' => array(
                'class' => 'DeleteAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Блок удален!',
                'error_message' => 'Блок не удален!',
                'e_404_message' => $this->_e_404_message,
            ),
            'create' => array(
                'class' => 'CreateAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Блок успешно создан!',
                'error_message' => 'Не удалось создать блок!',
            ),
            'update' => array(
                'class' => 'UpdateAction',
                'model_name' => $this->_model_name,
                'success_message' => 'Блок успешно изменен!',
                'error_message' => 'Не удалось изменить блок!',
                'e_404_message' => $this->_e_404_message,
            ),
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
                'actions' => array('create', 'index', 'update', 'delete'),
                'roles' => array(User::ROLE_GLOBAL_ADMIN, User::ROLE_GLOBAL_MANAGER),
            ),
            array('deny',
                'users' => array('?'),
            ),
        );
    }

}
