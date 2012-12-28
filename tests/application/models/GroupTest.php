<?php

class Application_Model_GroupTest extends PHPUnit_Framework_TestCase
{
    public function testCanPopulateGroup()
    {
        $data = array (
            'groupId' => 1,
            'groupName' => 'Test Group',
            'created' => '1999-12-31 23:59:59',
            'modified' => '2000-01-01 00:00:00',
        );
        $group = new Application_Model_Group($data);
        $this->assertSame($data['groupId'], $group->getId());
        $this->assertSame($data['groupName'], $group->getGroupName());
        $this->assertSame($data['created'], $group->getCreated()->format('Y-m-d H:i:s'));
        $this->assertSame($data['modified'], $group->getModified()->format('Y-m-d H:i:s'));
        $this->assertEquals($data, $group->toArray());
    }
}