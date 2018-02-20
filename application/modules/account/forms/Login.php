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
        $this->addElement('text', 'email', [
            'Label' => 'Your e-mail address',
            'Required' => true,
            'Filter' => [
                'StringTrim',
                'StripTags',
                'StringToLower',
            ],
            'Validators' => [
                'EmailAddress',
                 ['StringLength', false,  ['min' => 5, 'max' => 150]],
            ],
        ]);
        $this->addElement('password', 'password', [
            'Label' => 'Your password',
            'Required' => true,
            'Filters' => [],
            'Validators' => [],
            'Attribs' => [
                "autocomplete" => "off",
            ],
        ]);
        $this->addElement('submit', 'signin', [
            'Label' => 'Sign in',
            'Ignore' => true,
        ]);
//        $this->addElement('hash', 'token');
    }
}
