<?php

class Task_Form_Task extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'title', [
            'Label' => 'Task title',
            'Required' => true,
            'Filters' => [
                'StringTrim',
                'StripTags',
            ],
            'Validators' => [],
            'Size' => 35,
        ]);
        $this->addElement('textarea', 'description', [
            'Label' => 'Description',
            'Required' => false,
            'Filters' => [],
            'Validators' => [],
            'Cols' => 35,
            'Rows' => 12,
        ]);
        $this->addElement('text', 'dueDate', [
            'Label' => 'Due date',
            'Required' => true,
            'Filters' => [],
            'Validators' => [],
        ]);
        $this->addElement('checkbox', 'done', [
            'Label' => 'Done',
            'Required' => false,
            'Filters' => [
                'Int',
            ],
            'Validators' => [
                'Int',
                 ['Between', false,  ['min' => -1, 'max' => 1]],
            ],
        ]);
        $this->addElement('submit', 'save', [
            'Label' => 'Save this task',
            'Ignore' => true,
        ]);
        $this->addElement('hidden', 'projectId', [
            'Required' => true,
            'Filters' => [
                'Int',
            ],
            'Validators' => [
                'Int',
                 ['GreaterThan', false,  ['min' => 0]],
            ],
        ]);
        $this->addElement('hidden', 'taskId', [
            'Required' => true,
            'Filters' => [
                'Int',
            ],
            'Validators' => [
                'Int',
                 ['GreaterThan', false,  ['min' => -1]],
            ],
        ]);
    }
}
