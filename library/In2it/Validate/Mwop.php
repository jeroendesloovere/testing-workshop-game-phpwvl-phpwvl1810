<?php
/**
 * In2it Framework
 * 
 * Extends Zend Framework with custom functionality or overriding ZF 
 * functionality matching needs of the application
 * 
 * @category    In2it
 * @package     In2it
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
/**
 * In2it_Validate_Mwop
 * 
 * This is a validator to allow names like "Matthew Weier O'Phinney" and
 * "Dr. Keith C. Casey, Jr.".
 * 
 * @category   In2it
 * @package    In2it_Validate
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
class In2it_Validate_Mwop extends Zend_Validate_Abstract
{
    const MWOP = 'mwop';
    
    /**
     * @var array
     */
    protected $messageTemplates = array (
        self::MWOP => "'%value%' is not MWOP proof",
    );
    /**
     * Checks weather a name is valid or not.
     * 
     * @param string $fullname
     * @return boolean
     * @see Zend_Validate_Abstract::isValid()
     */
    public function isValid($fullname)
    {
        $this->_setValue($fullname);
        
        $check = preg_match('([\"\=\*\;\[\]\#\\\?]+)', $fullname);
        if (1 === $check) {
            $this->_error(self::MWOP, $fullname);
            return false;
        }
        return true;
    }
}