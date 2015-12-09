<?php
/**
 * Class Account_Form_Register
 *
 * @category TheiaLive
 * @package Account
 */
class Account_Form_Register extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'firstName', array (
            'Label' => 'First name',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (
                array ('Alpha', false, array ('allowWhitespace' => true)),
                array ('StringLength', false, array ('min' => 2, 'max' => 45)),
            ),
        ));
        $this->addElement('text', 'lastName', array (
            'Label' => 'Last name',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (
                array ('Regex', false, array ('pattern' => '/[a-zA-Z\-\'\s\.\,]+/')),
                array ('StringLength', false, array ('min' => 2, 'max' => 45)),
            ),
        ));
        $this->addElement('text', 'email', array (
            'Label' => 'E-mail address',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
                'StringToLower',
            ),
            'Validators' => array (
                'EmailAddress',
                array ('StringLength', false, array ('min' => 5, 'max' => 150)),
            ),
        ));
        $this->addElement('password', 'password', array (
            'Label' => 'Password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
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
            'Label' => 'Register now',
            'Ignore' => true,
        ));
//        $this->addElement('hash', 'token');
    }


}

