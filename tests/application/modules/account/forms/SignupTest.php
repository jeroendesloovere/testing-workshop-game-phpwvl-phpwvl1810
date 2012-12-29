<?php

class Account_Form_SignupTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('John','Doe','john.doe@example.com','abcd1234','abcd1234'),
            array ('John','Doe','john.doe+test@gmail.com','abcd1234','abcd1234'),
            array ('Matthew',"Weier O'Phinney",'matthew@weierophinney.net','zend framework','zend framework'),
            array ('Keith','Casey, Jr.','keith@caseysoftware.net','monkey01','monkey01'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('','','','',''),
            array ('John','Doe','john.doe@example.com','abcd1234',''),
            array ('John','Doe','john','abcd1234','abcd1234'),
            array ('John','Doe','john.doe@example.com','abc123','abc123'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testValidUsersCanRegister($firstname, $lastname, $email, $password, $verify)
    {
        $data = array (
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
            'verify' => $verify,
        );
        
        $form = new Account_Form_Signup();
        $result = $form->isValidPartial($data);
        $this->assertTrue($result);
    }
    /**
     * @dataProvider badDataProvider
     */
    public function testInvalidUsersCannotRegister($firstname, $lastname, $email, $password, $verify)
    {
        $data = array (
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
            'verify' => $verify,
        );
        
        $form = new Account_Form_Signup();
        $result = $form->isValidPartial($data);
        $this->assertFalse($result);
    }
}