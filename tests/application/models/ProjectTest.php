<?php

class Application_Model_ProjectTest extends PHPUnit_Framework_TestCase
{
    public function testCanPopulateProject()
    {
        $data = array (
            'projectId' => 1,
            'projectName' => 'Test Project',
            'created' => '1999-12-31 23:59:59',
            'modified' => '2000-01-01 00:00:00',
        );
        $project = new Application_Model_Project($data);
        $this->assertSame($data['projectId'], $project->getId());
        $this->assertSame($data['projectName'], $project->getProjectName());
        $this->assertSame($data['created'], $project->getCreated()->format('Y-m-d H:i:s'));
        $this->assertsame($data['modified'], $project->getModified()->format('Y-m-d H:i:s'));
        $this->assertEquals($data, $project->toArray());
    }
}