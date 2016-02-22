<?php

class Account_Model_AccountFilter
{
    /**
     * @var Zend_Filter_Input
     */
    protected $_inputFilter;

    public function init()
    {
        $filters = array (
            'accountId' => array (
                'Int',
            ),
            'firstName' => array (
                'StringTrim',
                'StripTags',
            ),
            'lastName' => array (
                'StringTrim',
                'StripTags',
            ),
            'email' => array (
                'StringTrim',
                'StripTags',
                'StringToLower',
            ),
            'password' => array (),
        );
        $validators = array (
            'accountId' => array (
                'Int',
                array ('GreaterThan', array ('min' => -1)),
            ),
            'firstName' => array (
                array ('Alnum', array ('allowWhiteSpace' => true)),
                array ('StringLength', array ('min' => 2)),
            ),
            'lastName' => array (
                array ('Alnum', array ('allowWhiteSpace' => true)),
                array ('StringLength', array ('min' => 2)),
            ),
            'email' => array (
                'EmailAddress',
                array ('StringLength', array ('min' => 2)),
            ),
            'password' => array (
                array ('StringLength', array ('min' => 8)),
            ),
        );
        $this->_inputFilter = new Zend_Filter_Input($filters, $validators);
    }

    public function __construct($data = array ())
    {
        $this->init();
        $this->_inputFilter->setData($data);
    }

    /**
     * @return Zend_Filter_Input
     */
    public function getInputFilter()
    {
        return $this->_inputFilter;
    }

    /**
     * @param null|string $fieldName
     * @return bool
     */
    public function isValid($fieldName = null)
    {
        return $this->_inputFilter->isValid($fieldName);
    }
}