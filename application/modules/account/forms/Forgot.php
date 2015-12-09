<?php
/**
 * Class Account_Form_Forgot
 *
 * @category TheiaLive
 * @package Account
 */
class Account_Form_Forgot extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'email', array (
            'Label' => 'Your e-mail address',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
                'StringToLower'
            ),
            'Validators' => array (
                'EmailAddress',
                array ('StringLength', false, array ('min' => 5, 'max' => 150)),
            ),
        ));
        $this->addElement('submit', 'request', array (
            'Label' => 'Send request',
            'Ignore' => true,
        ));
//        $this->addElement('hash', 'token');
    }


}

