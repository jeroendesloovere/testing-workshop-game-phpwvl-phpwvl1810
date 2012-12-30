<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Account_Form_NewPassword
 * 
 * @package Account_Form
 * @category NewPassword
 */
class Account_Form_NewPassword extends Zend_Form
{
    public function init()
    {
        $this->addElement('password', 'password', array (
            'Label' => 'Enter your new password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (
                array ('StringLength', false, array ('min' => 8)),
            ),
        ));
        $this->addElement('password', 'verify', array (
            'Label' => 'Verify your new password',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (
                array ('StringLength', false, array ('min' => 8)),
                array ('Identical', false, array ('token' => 'password')),
            ),
        ));
        $this->addElement('submit', 'save', array (
            'Label' => 'Save new password',
            'Ignore' => true,
        ));
        $this->addElement('hidden', 'token');
        $this->addElement('hash', 'hash');
    }


}

