<?php

class Project_Service_ProjectTest extends PHPUnit_Framework_TestCase
{
    protected $_account = array (
        'accountId' => 1,
        'name'      => 'Chris Hartjes',
        'email'     => 'test@hartjes.net',
        'password'  => 'test123',
        'created'   => '2012-12-25 10:00:00',
        'modified'  => '2012-12-25 11:00:00',
        'token'     => 'abcdefghijklmnopqrstuvwxyz0123456789',
    );
    
    public function testFetchesProjectsFromAccount()
    {
        $account = new Application_Model_Account($this->_account);
        $service = new Project_Service_Project();
        $result = $service->getAllProjects($account);
        
        $this->assertSame(3, count($result));
    }
}