<?php

class LoadBlockWidget extends CWidget
{
    public $alias;

    public function run()
    {
        $block_model = Block::model()->findByAlias($this->alias);

        if (isset($block_model->id)) {
            echo $this->getController()->decodeWidgets($block_model->body);
        }
    }
}

?>