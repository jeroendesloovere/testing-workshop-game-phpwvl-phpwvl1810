<?php

class Auth_Form_Register extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'name', array (
            'Label'       => 'Name',
            'Description' => '(e.g. Patrick E. Jones)',
            'Required'    => true,
            'Filters'     => array (
                'StripTags',
                'StringTrim',
            ),
            'Validators'  => array (
                array ('StringLength', false, array ('min' => 5, 'max' => 50)),
            ),
        ));
        
        $this->addElement('text', 'email', array (
            'Label'       => 'Email address',
            'Description' => '(e.g. patrick.jones@example.com)',
            'Required'    => true,
            'Filters'     => array (
                'StripTags',
                'StringTrim',
                'StringToLower',
            ),
            'Validators'  => array (
                'EmailAddress',
                array ('StringLength', false, array ('min' => 5, 'max' => 150)),
            ),
        ));
        $this->addElement('password', 'password', array (
            'Label'       => 'Password',
            'Description' => 'Min. 8 characters',
            'Required'    => true,
            'Filters'     => array (),
            'Validators'  => array (
                array ('StringLength', false, array ('min' => 8)),
            ),
        ));
        $this->addElement('password', 'passwordCheck', array (
            'Label'       => 'Verify password',
            'Description' => 'Use the same password to verify',
            'Required'    => true,
            'Filters'     => array (),
            'Validators'  => array (
                array ('Identical', false, array ('token' => 'password')),
            ),
        ));
        $this->addElement('submit', 'register', array (
            'Label'  => 'Register',
            'Ignore' => true,
        ));
        $this->addElement('hash', 'token');
    }


}

