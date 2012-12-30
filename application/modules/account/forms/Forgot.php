<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Account_Form_Forgot
 * 
 * @package Account_Form
 * @category Forgot
 */
class Account_Form_Forgot extends Zend_Form
{

    public function init()
    {
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
                array ('StringLength', false, array ('min' => 5, 'max' => 150)),
            ),
        ));
        $this->addElement('submit', 'reset', array (
            'Label' => 'Reset password',
            'Ignore' => true,
        ));
        $this->addElement('hash', 'token');
    }


}

