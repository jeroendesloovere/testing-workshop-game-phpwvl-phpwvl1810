<?php
/**
 * Class Application_Form_Contact
 *
 * @category TheiaLive
 * @package Default
 */
class Application_Form_Contact extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'name', [
            'Label' => 'Your name',
            'Required' => true,
            'Filters' => [
                'StringTrim',
                'StripTags',
            ],
            'Validators' => [
                 ['StringLength', false,  ['min' => 5, 'max' => 45]],
            ],
        ]);
        $this->addElement('text', 'email', [
            'Label' => 'Your email address',
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
        $this->addElement('textarea', 'comment', [
            'Label' => 'Your message',
            'Required' => false,
            'Filters' => [
                'StringTrim',
                'StripTags',
            ],
            'Validators' => [],
            'Rows' => 6,
            'Cols' => 35,
        ]);
        $this->addElement('submit', 'send', [
            'Label' => 'Send message',
            'Ignore' => true,
        ]);
        $this->addElement('hash', 'token');
    }
}
