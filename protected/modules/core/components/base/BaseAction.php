<?php
class BaseAction extends CAction
{
    public $pk = 'id';
    public $model_name;
    public $redirect_to = array('index');

    public $success_message = 'Операция произведена успешно!';
    public $error_message = 'Операцию не удалось произвести!';

    public $e_404_message = 'Запрашиваемая страница не найдена.';

    protected function _loadModel($id)
    {
        $model = CActiveRecord::model($this->model_name)->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, $this->e_404_message);
        }
        return $model;
    }
}