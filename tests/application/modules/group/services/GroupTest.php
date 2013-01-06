<?php

require_once 'DatabaseTestCase.php';
class Group_Service_GroupTest extends DatabaseTestCase
{
    public function testGroupCanBeCreated()
    {
        $account = new Application_Model_Account();
        $accountMapper = new Application_Model_AccountMapper();
        $accountMapper->find($account, 1);
        
        $service = new Group_Service_Group();
        $service->createGroup($account, 'Test Group 1');
        
        $groupDs = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $groupDs->addTable('group', 
            'SELECT groupId, groupName FROM `group`');
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/newGroupDataset.xml'), $groupDs);
        
        $groupAccountDs = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $groupAccountDs->addTable('groupAccount', 
            'SELECT * FROM `groupAccount`');
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/newGroupAccountDataset.xml'), $groupAccountDs);
    }
}