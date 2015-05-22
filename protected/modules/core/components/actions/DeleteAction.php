<?php

class DeleteAction extends BaseAction
{
    public $success_message = 'Удаление прошло успешно!';
    public $error_message = 'Не удалось произвести удаление!';

    public function run($id)
    {
        $this->_loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->getController()->setSuccess($this->success_message);
            $this->getController()->redirect($this->redirect_to);
        }
    }
} 