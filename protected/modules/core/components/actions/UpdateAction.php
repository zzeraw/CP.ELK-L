<?php

class UpdateAction extends BaseAction
{
    public $success_message = 'Изменения успешно внесены!';
    public $error_message = 'Не удалось сохранить изменения!';

    public function run($id)
    {
        $model = $this->_loadModel($id);

        if (isset($_POST[$this->model_name])) {
            $model->attributes = $_POST[$this->model_name];

            if (($model->validate()) && ($model->save())) {
                $this->getController()->setSuccess($this->success_message);
                $this->getController()->redirect($this->redirect_to);
            } else {
                $this->getController()->setError($this->error_message);
            }
        }

        $this->getController()->render('update',array(
            'model' => $model,
        ));
    }
}