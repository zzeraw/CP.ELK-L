<?php

class BWHomeUrl extends CWidget
{
    public $attr1 = 1;
    public $attr2 = 2;
    public $attr3 = 3;

    public function run()
    {
        var_dump($this->attr3);
        var_dump(json_decode($this->attr3));

        echo Yii::app()->getBaseUrl(true);
    }
}

?>