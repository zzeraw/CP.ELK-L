<?php

class IndexAction extends BaseAction
{
    public function run()
    {
        $model = new $this->model_name('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET[$this->model_name])) {
            $model->attributes = $_GET[$this->model_name];
        }

        $this->getController()->render('index', array(
            'model' => $model,
        ));
    }
} 