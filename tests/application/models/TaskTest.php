<?php

class Application_Model_TaskTest extends PHPUnit_Framework_TestCase
{
    public function testCanPopulateTask()
    {
        $data = array (
            'taskLabel' => 'Test task',
        );
        $task = new Application_Model_Task($data);
        $this->assertSame(0, $task->getId());
        $this->assertSame($data['taskLabel'], $task->getTaskLabel());
    }
}