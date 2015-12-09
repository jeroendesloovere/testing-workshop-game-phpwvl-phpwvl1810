<?php
/**
 * Class Account_Form_NewPassword
 *
 * @category TheiaLive
 * @package Account
 */
class Account_Form_NewPassword extends Zend_Form
{

    public function init()
    {
        $this->addElement('password', 'password', array (
            'Label' => 'Enter your new password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('password', 'verify', array (
            'Label' => 'Verify entered password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (
                array ('Identical', false, array ('token' => 'password')),
            ),
        ));
        $this->addElement('submit', 'save', array (
            'Label' => 'Save new password',
            'Ignore' => true,
        ));
        $this->addElement('hidden', 'email', array (
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
        $this->addElement('hidden', 'token', array (
            'Filters' => array (
                'StringTrim',
                'StripTags',
                'StringToLower',
            ),
            'Validators' => array (
                'Alnum',
                array ('StringLength', false, array ('min' => 40, 'max' => 40)),
            ),
        ));
//        $this->addElement('hash', 'hash');
    }


}

