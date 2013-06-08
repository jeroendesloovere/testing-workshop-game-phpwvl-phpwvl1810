<?php

class Application_Service_Mail
{
    /**
     * @var Zend_Mail The mail object completely set up
     */
    protected $_mail;

    /**
     * Constructor for the mail service that takes an optional
     * Zend_Mail parameter
     *
     * @param null|Zend_Mail $mail
     */
    public function __construct($mail = null)
    {
        if (null !== $mail) {
            $this->setMail($mail);
        }
    }

    /**
     * Sets the mail object
     *
     * @param Zend_Mail $mail
     * @return $this
     */
    public function setMail(Zend_Mail $mail)
    {
        $this->_mail = $mail;
        return $this;
    }

    /**
     * Retrieves the mail object
     *
     * @return Zend_Mail
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * Sends out the mail object to either the default mail transport
     * or to a file transport for testing
     *
     */
    public function send()
    {
        if ('testing' === APPLICATION_ENV) {
            $transport = new Zend_Mail_Transport_File();
        }
    }
}