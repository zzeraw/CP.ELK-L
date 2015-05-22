<?php

/**
 * Class DynamicFormModel
 *
 * Пользовательский класс. Необходим для динамического создания моделей.
 */
class DynamicFormModel extends CFormModel
{
    protected $_dynamicTypes = array();
    protected $_dynamicNames = array();
    protected $_dynamicLabels = array();
    protected $_dynamicValues = array();
    protected $_dynamicHtmlOptions = array();

    protected $_rules = array();

    public function setDynamicFields($fields)
    {
        foreach ($fields as $key => $value) {
            $this->_dynamicTypes[$value['name']] = $value['type'];
            $this->_dynamicNames[$value['name']] = $value['name'];
            $this->_dynamicLabels[$value['name']] = $value['label'];
            $this->_dynamicValues[$value['name']] = $value['value'];
        }
    }

    public function getFieldsArray($fields)
    {
        $result = array();

        foreach ($fields as $key => $value) {
            $result[$value['name']] = $value['label'];
        }

        return $result;
    }

    public function setDynamicFieldsHtmlOptions($options)
    {
        $this->_dynamicHtmlOptions = $options;
    }

    public function setDynamicRules($rules)
    {
        $this->_rules = $rules;
    }

    public function rules()
    {
        return $this->_rules;
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            $this->_dynamicLabels
        );
    }

    public function attributeNames()
    {
        return array_merge(
            parent::attributeNames(),
            array_keys($this->_dynamicNames)
        );
    }

    /**
     * Returns the value for a dynamic attribute, if not, falls back to parent
     * method
     *
     * @param type $name
     * @return type
     */
    public function __get($name)
    {
        if (!empty($this->_dynamicNames[$name])) {
            if (!empty($this->_dynamicValues[$name])) {
                return $this->_dynamicValues[$name];
            } else {
                return null;
            }

        } else {
            return parent::__get($name);
        }
    }

    /**
     * Overrides the setter to store dynamic data.
     *
     * @param type $name
     * @param type $val
     */
    public function __set($name, $val)
    {
        if (!empty($this->_dynamicNames[$name])) {
            $this->_dynamicValues[$name] = $val;
        } else {
            parent::__set($name, $val);
        }
    }

}