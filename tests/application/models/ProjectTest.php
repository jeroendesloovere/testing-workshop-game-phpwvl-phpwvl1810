<?php

class Application_Model_ProjectTest extends PHPUnit_Framework_TestCase
{
    public function testCanPopulateProject()
    {
        $data = array (
            'projectName' => 'Test Project',
        );
        $project = new Application_Model_Project($data);
        $this->assertSame(0, $project->getId());
        $this->assertSame($data['projectName'], $project->getProjectName());
    }
}