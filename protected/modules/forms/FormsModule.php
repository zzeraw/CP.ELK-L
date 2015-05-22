<?php

class FormsModule extends BaseWebModule
{
	public function init()
	{
		$this->_setImport();
	}

    protected function _setImport()
    {
        $this->setImport(array(
            $this->id . '.models.*',
            $this->id . '.models.forms.*',

            $this->id . '.components.*',
            $this->id . '.components.controllers.*',
            $this->id . '.components.custom.*',
            $this->id . '.components.widgets.*',
            $this->id . '.components.widgets.views.*',
        ));
    }
}
