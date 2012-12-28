<?php

abstract class Application_Model_Abstract extends In2it_Model_Model
{
    /**
     * Creates a default DateTime for a particular field
     * @param mixed $obj
     * @param string $field 
     */
    protected function _defaultTimeStamp($obj, $field)
    {
        if (!isset ($obj->$field)) {
            $obj->$field = new DateTime('now');
        }
    }
    /**
     * Sets a default value for a not set parameter
     * 
     * @param mixed $obj
     * @param string $field
     * @param mixed $value 
     */
    protected function _defaultValue($obj, $field, $value)
    {
        if (!isset ($obj->$field)) {
            $obj->$field = $value;
        }
    }
}

