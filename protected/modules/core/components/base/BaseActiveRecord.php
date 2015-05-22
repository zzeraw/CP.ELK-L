<?php

class BaseActiveRecord extends CActiveRecord
{
    protected function _setScopes()
    {
        $scopes = array();

        try {
            $active = $this->active;
            $active = true;
        } catch (Exception $e) {
            $active = false;
        }

        if ($active) {
            $scopes = array(
                'active' => array(
                    'condition' => 'active = 1'
                )
            );
        }

        return $scopes;
    }

    public function scopes()
    {
        $scopes = $this->_setScopes();

        return $scopes;
    }

    /**
     * TODO
     */
    public function findByAlias($string = false)
    {
        $alias = false;

        $alias = ($string === false) ? $this->alias : $string;

        return $this->findByAttributes(array('alias' => $alias));
    }

    public function findIdByAlias($string = false)
    {
        $alias = false;

        if ($string !== false) {
            $alias = $string;
        }

        $model = $this->findByAlias($alias);

        return $model->id;
    }

    public function modifyArgumentStringToId($string)
    {
        $id = false;

        if ($string === false) {
            $id = $this->id;
        } else {
            if (ctype_digit($string)) {
                $id = (int) $string;
            } else {
                $id = $this->findIdByAlias($string);
            }
        }

        return $id;
    }

    public function findAllByPkArray($array, $order = false, $limit = false)
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $array);
        if ($limit != false) {
            $criteria->limit = $limit;
        }
        $criteria->order = $order;
        $items_model = $this->findAll($criteria);
        return $items_model;
    }

    public function findLastModifiedDate()
    {
        return Yii::app()->db->createCommand("SELECT MAX(`modified_datetime`) FROM {{" . $this->tableName() . "}}")->queryScalar();
    }

    public function findLastModifiedDateByAttributes($array)
    {
        $model = $this->findByAttributes($array, array('select' => 'modified_datetime'));
        if (isset($model->modified_datetime)) {
            return $model->modified_datetime;
        }
    }

}
