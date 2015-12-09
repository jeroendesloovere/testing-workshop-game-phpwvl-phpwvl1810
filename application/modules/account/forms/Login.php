<?php
/**
 * Class Account_Form_Login
 *
 * @category TheiaLive
 * @package Account
 */
class Account_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'email', array (
            'Label' => 'Your e-mail address',
            'Required' => true,
            'Filter' => array (
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
            'Label' => 'Your password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('submit', 'signin', array (
            'Label' => 'Sign in',
            'Ignore' => true,
        ));
//        $this->addElement('hash', 'token');
    }


}

