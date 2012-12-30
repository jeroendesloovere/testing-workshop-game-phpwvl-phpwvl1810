<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Account_Form_Signup
 * 
 * @package Account_Form
 * @category Signup
 */
class Account_Form_Signup extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'firstName', array (
            'Label' => 'Your first name',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (
                array ('Alnum', null, array ('AllowWhitespace' => true)),
                array ('StringLength', null, array ('min' => 2, 'max' => 45)),
            ),
        ));
        $this->addElement('text', 'lastName', array (
            'Label' => 'Your last name',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (
                new In2it_Validate_Mwop(),
                array ('StringLength', null, array ('min' => 2, 'max' => 45)),
            ),
        ));
        $this->addElement('text', 'email', array (
            'Label' => 'Your email address',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
                'StringToLower',
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
                array ('StringLength', false, array ('min' => 8)),
            ),
        ));
        $this->addElement('password', 'verify', array (
            'Label' => 'Verify password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (
                array ('Identical', false, array ('token' => 'password')),
            ),
        ));
        $this->addElement('submit', 'register', array (
            'Label' => 'Sign up',
            'Ignore' => true,
        ));
        $this->addElement('hash', 'token');
    }


}

