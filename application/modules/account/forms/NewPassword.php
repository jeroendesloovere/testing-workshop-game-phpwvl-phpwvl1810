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
        $this->addElement('password', 'password', [
            'Label' => 'Enter your new password',
            'Required' => true,
            'Filters' => [],
            'Validators' => [],
            'Attribs' => [
                "autocomplete" => "off",
            ],
        ]);
        $this->addElement('password', 'verify', [
            'Label' => 'Verify entered password',
            'Required' => true,
            'Filters' => [],
            'Validators' => [
                 ['Identical', false,  ['token' => 'password']],
            ],
            'Attribs' => [
                "autocomplete" => "off",
            ],
        ]);
        $this->addElement('submit', 'save', [
            'Label' => 'Save new password',
            'Ignore' => true,
        ]);
        $this->addElement('hidden', 'email', [
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
        $this->addElement('hidden', 'token', [
            'Filters' => [
                'StringTrim',
                'StripTags',
                'StringToLower',
            ],
            'Validators' => [
                'Alnum',
                 ['StringLength', false,  ['min' => 40, 'max' => 40]],
            ],
        ]);
//        $this->addElement('hash', 'hash');
    }
}
