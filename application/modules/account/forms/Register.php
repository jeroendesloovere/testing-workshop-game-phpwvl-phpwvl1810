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
        $this->addElement('text', 'firstName', [
            'Label' => 'First name',
            'Required' => true,
            'Filters' => [
                'StringTrim',
                'StripTags',
            ],
            'Validators' => [
                 ['Alpha', false,  ['allowWhitespace' => true]],
                 ['StringLength', false,  ['min' => 2, 'max' => 45]],
            ],
        ]);
        $this->addElement('text', 'lastName', [
            'Label' => 'Last name',
            'Required' => true,
            'Filters' => [
                'StringTrim',
                'StripTags',
            ],
            'Validators' => [
                 ['Regex', false,  ['pattern' => '/[a-zA-Z\-\'\s\.\,]+/']],
                 ['StringLength', false,  ['min' => 2, 'max' => 45]],
            ],
        ]);
        $this->addElement('text', 'email', [
            'Label' => 'E-mail address',
            'Required' => true,
            'Filters' => [
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
            'Label' => 'Password',
            'Required' => true,
            'Filters' => [],
            'Validators' => [
                ['StringLength', false, ['max' => 500]],
            ],
            'Attribs' => [
                "autocomplete" => "off",
            ],
        ]);
        $this->addElement('password', 'verify', [
            'Label' => 'Verify password',
            'Required' => true,
            'Filters' => [],
            'Validators' => [
                ['StringLength', false, ['max' => 500]],
                ['Identical', false,  ['token' => 'password']],
            ],
            'Attribs' => [
                "autocomplete" => "off",
            ],
        ]);
        $this->addElement('submit', 'register', [
            'Label' => 'Register now',
            'Ignore' => true,
        ]);
        $this->addElement('hash', 'token');
    }
}
