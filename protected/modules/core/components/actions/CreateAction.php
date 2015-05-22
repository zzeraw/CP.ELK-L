<?php

class CreateAction extends BaseAction
{
    public $success_message = 'Элемент успешно создан!';
    public $error_message = 'Не удалось создать элемент!';

    public function run()
    {
        $model = new $this->model_name;

        if (isset($_POST[$this->model_name])) {
            $model->attributes = $_POST[$this->model_name];
            if (($model->validate()) && ($model->save())) {
                $this->getController()->setSuccess($this->success_message);
                $this->getController()->redirect($this->redirect_to);
            } else {
                $this->getController()->setError($this->error_message);
            }
        }

        $this->getController()->render('create', array(
            'model' => $model,
        ));
    }
}