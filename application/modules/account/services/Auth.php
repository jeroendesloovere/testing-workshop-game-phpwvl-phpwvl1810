<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Account_Service_Auth
 * 
 * @package Account_Service
 * @category Auth
 */
class Account_Service_Auth
{
    protected $_dbAdapter;
    
    public function __construct($dbAdapter = null)
    {
        if (null !== $dbAdapter) {
            $this->setDbAdapter($dbAdapter);
        }
    }
    public function setDbAdapter($dbAdapter)
    {
        $this->_dbAdapter = $dbAdapter;
    }
    public function getDbAdapter()
    {
        return $this->_dbAdapter;
    }
    public function authenticate($username, $password)
    {
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Application_Model_Auth($username, $password);
        
        $authAdapter->setDbAdapter($this->getDbAdapter());
        $result = $auth->authenticate($authAdapter);
        
        if (!$result->isValid()) {
            return false;
        }
        $storage = $auth->getStorage();
        $account = new Application_Model_Account($authAdapter->getResultRowObject());
        $storage->write(serialize($account));
        return true;
    }
    public function registerAccount($data)
    {
        $account = new Application_Model_Account($data);
        $accountMapper = new Application_Model_AccountMapper();
        $accountMapper->save($account);
        
        $newAccount = new Application_Model_Account();
        $accountMapper->fetchRow($newAccount, array (
            'firstName LIKE ?' => $data['firstName'],
            'lastName LIKE ?' => $data['lastName'],
            'email LIKE ?' => $data['email'],
        ));
        if (0 === $newAccount->getId()) {
            throw new RuntimeException('Something went wrong storing your account');
        }
        $this->sendRegistrationMail($newAccount);
    }
    public function sendRegistrationMail(Application_Model_Account $account)
    {
        $html = file_get_contents(APPLICATION_PATH . '/templates/mail/registration.html');
        $text = file_get_contents(APPLICATION_PATH . '/templates/mail/registration.txt');
        
        $user = sprintf('%s %s', $account->getFirstName(), $account->getLastName());
        $host = $_SERVER['HTTP_HOST'];
        $link = sprintf('%s://%s/%s/%s/%s/%s/%s',
                isset ($_SERVER['HTTPS']) ? 'https' : 'http',
                $host,
                'account',
                'auth',
                'verify',
                'token',
                $account->getToken());
        
        $html = str_replace('{{NAME}}', $user, $html);
        $html = str_replace('{{SITE_LINK}}', $host, $html);
        $html = str_replace('{{REGISTRATION_LINK}}', $link, $html);
        
        $text = str_replace('{{NAME}}', $user, $text);
        $text = str_replace('{{SITE_LINK}}', $host, $text);
        $text = str_replace('{{REGISTRATION_LINK}}', $link, $text);
        
        $mail = new Zend_Mail();
        $mail->setFrom('registration@theialive.com', 'TheiaLive Registration');
        $mail->addTo($account->getEmail(), $user);
        $mail->addHeader('X-Mailer', 'TheiaLive Mailer');
        $mail->setBodyHtml($html);
        $mail->setBodyText($text);
        $mail->setSubject('Confirm your registration at TheiaLive');
        
        $mail->send();
        
    }
    
    public function verifyAccountByToken($token)
    {
        $account = new Application_Model_Account();
        $accountMapper = new Application_Model_AccountMapper();
        
        $accountMapper->fetchRow($account, array ('token LIKE ?' => $token));
        
        $account->setActive();
        $account->setToken(null);
        $account->setModified(new DateTime('now'));
        
        $accountMapper->save($account);
    }
    public function findAccountByEmail($email)
    {
        $account = new Application_Model_Account();
        $accountMapper = new Application_Model_AccountMapper();
        $accountMapper->fetchRow($account, array ('email LIKE ?' => $email));
        return $account;
    }
    
    public function resetAccount(Application_Model_Account $account)
    {
        $accountMapper = new Application_Model_AccountMapper();
        $account->setToken(Application_Model_Account::generateToken());
        $account->setActive(0);
        $account->setModified(new DateTime('now'));
        $accountMapper->save($account);
        $this->sendResetDetails($account);
    }
    public function sendResetDetails(Application_Model_Account $account)
    {
        $html = file_get_contents(APPLICATION_PATH . '/templates/mail/reset-password.html');
        $text = file_get_contents(APPLICATION_PATH . '/templates/mail/reset-password.txt');
        
        $user = sprintf('%s %s', $account->getFirstName(), $account->getLastName());
        $host = $_SERVER['HTTP_HOST'];
        $link = sprintf('%s://%s/%s/%s/%s/%s/%s',
                isset ($_SERVER['HTTPS']) ? 'https' : 'http',
                $host,
                'account',
                'auth',
                'new-password',
                'token',
                $account->getToken());
        
        $html = str_replace('{{NAME}}', $user, $html);
        $html = str_replace('{{SITE_LINK}}', $host, $html);
        $html = str_replace('{{REGISTRATION_LINK}}', $link, $html);
        
        $text = str_replace('{{NAME}}', $user, $text);
        $text = str_replace('{{SITE_LINK}}', $host, $text);
        $text = str_replace('{{REGISTRATION_LINK}}', $link, $text);
        
        $mail = new Zend_Mail();
        $mail->setFrom('registration@theialive.com', 'TheiaLive Registration');
        $mail->addTo($account->getEmail(), $user);
        $mail->addHeader('X-Mailer', 'TheiaLive Mailer');
        $mail->setBodyHtml($html);
        $mail->setBodyText($text);
        $mail->setSubject('Request for a new password at TheiaLive');
        
        $mail->send();
    }
    public function setNewAccountPassword($password, $token)
    {
        if (!$this->tokenExists($token)) {
            return false;
        }
        
        $account->setToken(null);
        $account->setPassword($password);
        $account->setModified(new DateTime('now'));
        $account->setActive(1);
        $accountMapper->save($account);
        return true;
    }
    public function tokenExists($token = null)
    {
        if (null === $token) {
            return false;
        }
        $account = new Application_Model_Account();
        $accountMapper = new Application_Model_AccountMapper();
        
        $accountMapper->fetchRow($account, array ('token LIKE ?' => $token));
        
        if (0 === (int) $account->getId()) {
            return false;
        }
        return true;
    }
}