<?php

class BWCreateUrl extends CWidget
{
    public $route;
    public $params = '';

    public function run()
    {
        if (!empty($this->params)) {
            $params = json_decode($this->params);

            if (!is_array($params)) {
                $params = array();
            }
        } else {
            $params = array();
        }

        echo Yii::app()->createUrl($this->route, $params);
    }
}

?>