<?php
/**
 * @group Application_Model
 * @group Application_Model_Account
 * @group Model
 */
require_once 'DatabaseTestCase.php';
class Application_Model_AccountTest extends DatabaseTestCase
{
    public function testPasswordNotStoredInPlainText()
    {
        $password = 'test1234';
        $this->assertNotSame($password, Application_Model_Account::generatePasswordHash($password));
        $this->assertEquals(13, strlen(Application_Model_Account::generatePasswordHash($password)));
    }
    public function testCreatingAccountWithMinimalData()
    {
        $data = array (
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'test1234',
        );
        $account = new Application_Model_Account($data);
        $this->assertSame(0, $account->getId());
        $this->assertSame($data['firstName'], $account->getFirstName());
        $this->assertSame($data['lastName'], $account->getLastName());
        $this->assertSame($data['email'], $account->getEmail());
        $this->assertSame(Application_Model_Account::generatePasswordHash($data['password']), $account->getPassword());
        $this->assertFalse($account->isActive());
    }
    public function testAccountCanBePopulated()
    {
        $data = array (
            'accountId' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'test1234',
            'token' => 'abcdefghijklmnopqrestuvwxyzABCDEFGHIJKLMNOP',
            'created' => '1999-12-31 23:59:59',
            'modified' => '2000-01-01 00:00:00',
            'active' => 1,
        );
        $account = new Application_Model_Account($data);
        $this->assertSame($data['accountId'], $account->getId(), 'Error with id');
        $this->assertSame($data['firstName'], $account->getFirstName(), 'Error with first name');
        $this->assertSame($data['lastName'], $account->getLastName(), 'Error with last name');
        $this->assertSame($data['email'], $account->getEmail(), 'Error with email');
        $this->assertSame(Application_Model_Account::generatePasswordHash($data['password']), $account->getPassword(), 'Error with password');
        $this->assertSame($data['token'], $account->getToken(), 'Error with token');
        $this->assertSame($data['created'], $account->getCreated()->format('Y-m-d H:i:s'), 'Error with created');
        $this->assertSame($data['modified'], $account->getModified()->format('Y-m-d H:i:s'), 'Error with modified');
        $this->assertTrue($account->isActive());
        $data['password'] = Application_Model_Account::generatePasswordHash($data['password']);
        $this->assertEquals($data, $account->toArray(), 'Error with toArray() method');
    }
    
    /** database integration tests **/
    
    public function testAccountIsFoundInDatabase()
    {
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 'SELECT * FROM `account`');
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
                TEST_PATH . '/_files/selectAccountDataset.xml'), $ds);
    }
    
    public function testAccountCanBeCreatedInDatabase()
    {
        $data = array (
            'firstName' => 'Jonny',
            'lastName' => 'Test',
            'email' => 'jonny.test@example.com',
            'password' => 'Test4Fun',
        );
        $account = new Application_Model_Account($data);
        $accountMapper = new Application_Model_AccountMapper();
        $accountMapper->save($account);
        
        $data['accountId'] = $account->getId();
        $data['password'] = Application_Model_Account::generatePasswordHash($data['password']);
        $data['token'] = '';
        $data['created'] = $account->getCreated()->format('Y-m-d H:i:s');
        $data['modified'] = $account->getModified()->format('Y-m-d H:i:s');
        $data['active'] = 0;
        
        $this->assertEquals($data, $account->toArray());
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 
            'SELECT accountId, firstName, lastName, email, password, token, active FROM `account`');
        
        require_once 'PHPUnit/Extensions/Database/Dataset/DataSetFilter.php';
        $filteredDs = new PHPUnit_Extensions_Database_DataSet_DataSetFilter(
            $ds, array ('created','modified'));
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/newAccountDataset.xml'), $filteredDs);
    }
}