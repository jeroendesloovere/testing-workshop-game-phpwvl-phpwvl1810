<?php
/**
 * Class Account_Model_AccountTest
 *
 * @group Account_Model_AccountTest
 * @group Account
 */
class Account_Model_AccountTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        $max = 5;
        $data = array ();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $max; $i++) {
            $entry = array (
                'accountId' => $faker->randomDigitNotNull,
                'firstName' => $faker->firstName,
                'lastName'  => $faker->lastName,
                'email'     => $faker->email,
                'password'  => $faker->text(50),
                'token'     => $faker->md5,
                'active'    => $faker->numberBetween(0,1),
                'reset'     => $faker->numberBetween(0,1),
                'created'   => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                'modified'  => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
            );
            $data[] = array ($entry);
        }
        return $data;
    }

    public function goodDataObjectProvider()
    {
        $max = 5;
        $data = array ();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $max; $i++) {
            $entry = new stdClass();
            $entry->accountId = $faker->randomDigitNotNull;
            $entry->firstName = $faker->firstName;
            $entry->lastName = $faker->lastName;
            $entry->email = $faker->email;
            $entry->password = $faker->text(50);
            $entry->token = $faker->md5;
            $entry->active = $faker->numberBetween(0,1);
            $entry->reset = $faker->numberBetween(0,1);
            $entry->created = $faker->dateTimeThisDecade->format('Y-m-d H:i:s');
            $entry->modified = $faker->dateTimeThisYear->format('Y-m-d H:i:s');
            $data[] = array ($entry);
        }
        return $data;
    }

    public function badIdDataProvider()
    {
        return array (
            array (''),
            array ('Foo'),
            array ('Foo Bar'),
        );
    }

    /**
     * @covers Account_Model_Account::getId
     * @dataProvider badIdDataProvider
     */
    public function testAccountRejectsBadValues($id)
    {
        $data = array (
            'accountId' => $id,
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'password' => '',
            'token' => '',
            'active' => '',
            'reset' => '',
            'created' => '',
            'modified' => '',
        );
        $account = new Account_Model_Account($data);
        $this->assertSame(0, $account->getId());
    }

    /**
     * @covers Account_Model_Account::__construct
     * @covers Account_Model_Account::setId
     * @covers Account_Model_Account::setFirstName
     * @covers Account_Model_Account::getFirstName
     * @covers Account_Model_Account::setLastName
     * @covers Account_Model_Account::getLastName
     * @covers Account_Model_Account::setEmail
     * @covers Account_Model_Account::getEmail
     * @covers Account_Model_Account::setPassword
     * @covers Account_Model_Account::getPassword
     * @covers Account_Model_Account::setToken
     * @covers Account_Model_Account::getToken
     * @covers Account_Model_Account::setActive
     * @covers Account_Model_Account::isActive
     * @covers Account_Model_Account::setReset
     * @covers Account_Model_Account::isReset
     * @covers Account_Model_Account::setCreated
     * @covers Account_Model_Account::getCreated
     * @covers Account_Model_Account::setModified
     * @covers Account_Model_Account::getModified
     * @dataProvider goodDataProvider
     */
    public function testAccountPopulateByIndiviudalFields($data)
    {
        $account = new Account_Model_Account();

        $account->setId($data['accountId']);
        $this->assertSame($data['accountId'], $account->getId());

        $account->setFirstName($data['firstName']);
        $this->assertSame($data['firstName'], $account->getFirstName());

        $account->setLastName($data['lastName']);
        $this->assertSame($data['lastName'], $account->getLastName());

        $account->setEmail($data['email']);
        $this->assertSame($data['email'], $account->getEmail());

        $account->setPassword($data['password']);
        $this->assertSame($data['password'], $account->getPassword());

        $account->setToken($data['token']);
        $this->assertSame($data['token'], $account->getToken());

        $account->setActive($data['active']);
        $active = (1 === $data['active']);
        $this->assertSame($active, $account->isActive());

        $account->setReset($data['reset']);
        $reset = (1 === $data['reset']);
        $this->assertSame($reset, $account->isReset());

        $account->setCreated($data['created']);
        $this->assertSame($data['created'], $account->getCreated()->format('Y-m-d H:i:s'));

        $account->setModified($data['modified']);
        $this->assertSame($data['modified'], $account->getModified()->format('Y-m-d H:i:s'));
    }

    /**
     * @covers Account_Model_Account::__construct
     * @covers Account_Model_Account::setCreated
     * @covers Account_Model_Account::getCreated
     */
    public function testAccountCreatedAcceptsDateTimeObject()
    {
        $account = new Account_Model_Account();

        $faker = \Faker\Factory::create();
        $date = $faker->dateTime;
        $account->setCreated($date);
        $this->assertSame($date, $account->getCreated());
    }

    /**
     * @covers Account_Model_Account::__construct
     * @covers Account_Model_Account::setModified
     * @covers Account_Model_Account::getModified
     */
    public function testAccountModifiedAcceptsDateTimeObject()
    {
        $account = new Account_Model_Account();

        $faker = \Faker\Factory::create();
        $date = $faker->dateTime;
        $account->setModified($date);
        $this->assertSame($date, $account->getModified());
    }

    /**
     * @covers Account_Model_Account::__construct
     * @covers Account_Model_Account::populate
     * @covers Account_Model_Account::getId
     * @dataProvider goodDataObjectProvider
     */
    public function testAccountCanPopulateObject($dataObj)
    {
        $account = new Account_Model_Account($dataObj);
        $this->assertSame($dataObj->accountId, $account->getId());
    }

    /**
     * @covers Account_Model_Account::__construct
     * @covers Account_Model_Account::getId
     * @dataProvider badIdDataProvider
     */
    public function testAccountAcceptsSinglePropertyValue($id)
    {
        $data = array (
            'accountId' => $id,
        );
        $account = new Account_Model_Account($data);
        $this->assertSame(0, $account->getId());
    }

    /**
     * @dataProvider goodDataProvider
     * @covers Account_Model_Account::__construct
     * @covers Account_Model_Account::populate
     * @covers Account_Model_Account::toArray
     */
    public function testAccountCanBeProvided($data)
    {
        $account = new Account_Model_Account($data);
        $this->assertEquals($data, $account->toArray());
    }

    /**
     * @covers Account_Model_Account::generatePasswordHash
     */
    public function testAccountCanHashPasswords()
    {
        $hash = Account_Model_Account::generatePasswordHash('foobar');
        $this->assertSame('YoWZfY.hunB3.', $hash);
    }

    /**
     * @covers Account_Model_Account::generateToken
     */
    public function testAccountCanGenerateToken()
    {
        $token = Account_Model_Account::generateToken();
        $this->assertSame(40, strlen($token));
    }
}
