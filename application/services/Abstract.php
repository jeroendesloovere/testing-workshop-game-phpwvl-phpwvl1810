<?php

abstract class Application_Service_Abstract
{
    protected $_mapper;
    
    public function __construct($mapper = null)
    {
        if (null !== $mapper) {
            $this->setMapper($mapper);
        }
    }
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    public function getMapper()
    {
        return $this->_mapper;
    }
}