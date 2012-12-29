<?php

class Application_Model_TaskTest extends PHPUnit_Framework_TestCase
{
    public function testCanPopulateTask()
    {
        $data = array (
            'taskId' => 1,
            'taskLabel' => 'Test task',
            'created' => '1999-12-31 23:59:59',
            'modified' => '2000-01-01 00:00:00',
        );
        $task = new Application_Model_Task($data);
        $this->assertSame($data['taskId'], $task->getId());
        $this->assertSame($data['taskLabel'], $task->getTaskLabel());
        $this->assertSame($data['created'], $task->getCreated()->format('Y-m-d H:i:s'));
        $this->assertSame($data['modified'], $task->getModified()->format('Y-m-d H:i:s'));
        $this->assertEquals($data, $task->toArray());
    }
}