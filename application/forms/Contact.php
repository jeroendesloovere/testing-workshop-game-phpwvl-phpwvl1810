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
        $this->addElement('text', 'name', array (
            'Label' => 'Your name',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (
                array ('StringLength', false, array ('min' => 5, 'max' => 45)),
            ),
        ));
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
        $this->addElement('textarea', 'comment', array (
            'Label' => 'Your message',
            'Required' => false,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (),
            'Rows' => 6,
            'Cols' => 35,
        ));
        $this->addElement('submit', 'send', array (
            'Label' => 'Send message',
            'Ignore' => true,
        ));
        $this->addElement('hash', 'token');
    }


}

