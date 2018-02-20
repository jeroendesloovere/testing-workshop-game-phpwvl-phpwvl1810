<?php

class Project_Form_Project extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'projectName', [
            'Label' => 'Project title',
            'Required' => true,
            'Filters' => [
                'StringTrim',
                'StripTags',
            ],
            'Validators' => [
                 ['Alnum', false,  ['allowWhiteSpace' => true]],
                 ['StringLength', false,  ['min' => 1, 'max' => 45]],
            ],
        ]);
        $this->addElement('submit', 'save', [
            'Label' => 'Save project',
            'Ignore' => true,
        ]);
        $this->addElement('hidden', 'projectId', [
            'Required' => true,
            'Value' => 0,
            'Filters' => [
                'Int',
            ],
            'Validators' => [
                'Int',
                 ['GreaterThan', false,  ['min' => -1]],
            ],
        ]);
//        $this->addElement('hash', 'token');
    }
}
