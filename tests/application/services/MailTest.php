<?php

class Application_Service_MailTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateEmail()
    {
        $mail = new Application_Service_Mail(
            array (
                'fromName' => 'John Doe',
                'fromEmail' => 'john.doe@example.com',
                'subject' => 'Testing contact form',
                'template' => Application_Service_Mail::TPL_CONTACT,
            )
        );
    }
}