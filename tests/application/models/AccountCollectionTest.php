<?php
/**
 * @group Application_Model
 * @group Application_Model_Account
 * @group Collection
 */
class Application_Model_AccountCollectionTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('John', 'Doe', 'j.d@example.com','test1234'),
            array ('Jane', 'Tarzan', 'j.t@junglebook.com', 'abcd8765'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testObjectReturnsCollectionOfAccounts($firstName, $lastName, $email, $password)
    {
        $data = array (
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $password,
        );
        $collection = new Application_Model_AccountCollection();
        $collection->addElement(new Application_Model_Account($data));
        
        $this->assertSame(1, count($collection));
        $this->assertType('Application_Model_Account', $collection->current());
        $this->assertSame(0, $collection->current()->getId());
        $this->assertSame($data['firstName'], $collection->current()->getFirstName());
        $this->assertSame($data['lastName'], $collection->current()->getLastName());
        $this->assertSame($data['email'], $collection->current()->getEmail());
        $this->assertSame(Application_Model_Account::generatePasswordHash($data['password']), $collection->current()->getPassword());
        $this->assertFalse($collection->current()->isActive());
    }
}