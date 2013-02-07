<?php

class Task_Form_Task extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'title', array (
            'Label' => 'Task title',
            'Required' => true,
            'Filters' => array (
                'StringTrim',
                'StripTags',
            ),
            'Validators' => array (),
            'Size' => 35,
        ));
        $this->addElement('textarea', 'description', array (
            'Label' => 'Description',
            'Required' => false,
            'Filters' => array (),
            'Validators' => array (),
            'Cols' => 35,
            'Rows' => 12,
        ));
        $this->addElement('text', 'dueDate', array (
            'Label' => 'Due date',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('submit', 'save', array (
            'Label' => 'Save this task',
            'Ignore' => true,
        ));
        $this->addElement('hidden', 'projectId', array (
            'Required' => true,
            'Filters' => array (
                'Int',
            ),
            'Validators' => array (
                'Int',
                array ('GreaterThan', false, array ('min' => 0)),
            ),
        ));
        $this->addElement('hidden', 'taskId', array (
            'Required' => true,
            'Filters' => array (
                'Int',
            ),
            'Validators' => array (
                'Int',
                array ('GreaterThan', false, array ('min' => -1)),
            ),
        ));
    }
}

