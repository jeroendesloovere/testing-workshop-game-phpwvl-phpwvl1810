<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Account_Form_Login
 * 
 * @package Account_Form
 * @category Login
 */
class Account_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'email', array (
            'Label' => 'Your email address',
            'Required' => true,
            'Filters' => array (
                'StringToLower',
                'StripTags',
                'StringTrim',
            ),
            'Validators' => array (
                'EmailAddress',
                array ('StringLength', null, array ('min' => 5, 'max' => 150)),
            )
        ));
        $this->addElement('password', 'password', array (
            'Label' => 'Your password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (
                array ('StringLength', null, array ('min' => 8)),
            ),
        ));
        $this->addElement('submit', 'login', array (
            'Label' => 'Login',
            'Ignore' => true,
        ));
        $this->addElement('hash','token');
    }


}

