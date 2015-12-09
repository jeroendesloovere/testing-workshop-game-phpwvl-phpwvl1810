<?php

class Project_Form_Project extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'projectName', array (
            'Label' => 'Project title',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (
                array ('Alnum', false, array ('allowWhiteSpace' => true)),
                array ('StringLength', false, array ('min' => 1, 'max' => 45)),
            ),
        ));
        $this->addElement('submit', 'save', array (
            'Label' => 'Save project',
            'Ignore' => true,
        ));
        $this->addElement('hidden', 'projectId', array (
            'Required' => true,
            'Value' => 0,
            'Filters' => array (
                'Int',
            ),
            'Validators' => array (
                'Int',
                array ('GreaterThan', false, array ('min' => -1)),
            ),
        ));
//        $this->addElement('hash', 'token');
    }


}

