<?php
class BSystemInfoBehavior extends CActiveRecordBehavior
{
    public function beforeSave($event)
    {
        $this->_setDatetime();
        $this->_setUserId();
        $this->_setUserName();
        $this->_setIpAndUserAgent();
    }

    protected function _setDatetime()
    {
        $date = date('Y-m-d H:i:s');

        if ($this->owner->isNewRecord) {
            $this->owner->created_datetime = $date;

            if (isset($this->owner->modified_datetime)) {
                $this->owner->modified_datetime = $date;
            }
        } else {
            $this->owner->modified_datetime = $date;
        }
    }

    protected function _setUserId()
    {
        $id = Yii::app()->user->id;

        if ($this->owner->isNewRecord) {
            $this->owner->created_user = $this->owner->modified_user = $id;
        } else {
            $this->owner->modified_user = $id;
        }
    }

    protected function _setUserName()
    {
        $username = Yii::app()->user->name;

        if ($this->owner->isNewRecord) {
            $this->owner->created_username = $this->owner->modified_username = $username;
        } else {
            $this->owner->modified_username = $username;
        }
    }

    protected function _setIpAndUserAgent()
    {
        $ip = Yii::app()->request->getUserHostAddress() . ' ' . Yii::app()->request->getUserAgent();

        if ($this->owner->isNewRecord) {
            $this->owner->created_ip = $ip;

            if (isset($this->owner->modified_ip)) {
                $this->owner->modified_ip = $ip;
            }
        } else {
            $this->owner->modified_ip = $ip;
        }
    }
}