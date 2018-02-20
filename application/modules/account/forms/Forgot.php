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
        $this->addElement('text', 'email', [
            'Label' => 'Your e-mail address',
            'Required' => true,
            'Filters' => [
                'StringTrim',
                'StripTags',
                'StringToLower'
            ],
            'Validators' => [
                'EmailAddress',
                 ['StringLength', false,  ['min' => 5, 'max' => 150]],
            ],
        ]);
        $this->addElement('submit', 'request', [
            'Label' => 'Send request',
            'Ignore' => true,
        ]);
//        $this->addElement('hash', 'token');
    }
}
