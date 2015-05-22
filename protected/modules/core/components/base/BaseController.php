<?php

class BaseController extends CController
{
    public $layout = 'core.views.templates.default';

    public $breadcrumbs = array();
    public $menu = array();

    public function init()
    {
        parent::init();
    }

    // флеш-нотис пользователю
    public function setSuccess($message)
    {
        return Yii::app()->user->setFlash('success', $message);
    }

    // флеш-нотис пользователю
    public function setNotice($message)
    {
        return Yii::app()->user->setFlash('warning', $message);
    }

    // флеш-ошибка пользователю
    public function setError($message)
    {
        return Yii::app()->user->setFlash('danger', $message);
    }

    protected function _loadModel($id, $model_name, $error_message = 'Страница не найдена')
    {
        $model = CActiveRecord::model($model_name)->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, $error_message);
        }
        return $model;
    }

}