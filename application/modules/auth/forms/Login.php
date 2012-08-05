<?php

class Auth_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'email', array (
            'Label'       => 'E-mail address',
            'Description' => 'richard.smith@example.com',
            'Required'    => true,
            'Filters'     => array (
                'StringToLower',
                'StripTags',
                'StringTrim',
            ),
            'Validators'  => array (
                'EmailAddress',
                array ('StringLength', false, array ('min' => 5, 'max' => 150)),
            ),
        ));
        
        $this->addElement('password', 'password', array (
            'Label'       => 'Password',
            'Description' => 'Your secret password',
            'Required'    => true,
            'Filters'     => array (),
            'Validators'  => array (
                array ('StringLength', false, array ('min' => 8)),
            ),
        ));
        
        $this->addElement('submit', 'login', array (
            'Label'  => 'Sign in',
            'Ignore' => true,
        ));
        
        $this->addElement('hash', 'token');
    }


}

