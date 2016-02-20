<?php

class Application_Service_MailTest extends PHPUnit_Framework_TestCase
{
    public function testServiceCanSendOutMails()
    {
        $mail = new Zend_Mail();
        $mail->addTo('me@home.net')
            ->setFrom('me@work.com')
            ->setSubject('Sending out test emails')
            ->setBodyText('Sending out test emails');

        $config = array ('path' => __DIR__ . '/_files/mail');
        $mailService = new Application_Service_Mail($mail, $config);
        $result = $mailService->send();

        $this->assertNotFalse($result);
        $this->assertFileExists($config['path']);
    }
}