<?php
/**
 * Class Account_IndexController
 *
 * @category TheiaLive
 * @package Account
 */
class Account_IndexController extends Zend_Controller_Action
{

    protected $_session = null;

    public function init()
    {
        $this->_session = new Zend_Session_Namespace('Account');
    }

    public function indexAction()
    {
        // action body
    }

    public function signupAction()
    {
        $form = new Account_Form_Register([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'register',
            ], null, true),
        ]);
        if (isset($this->_session->register)) {
            $form = unserialize($this->_session->register);
            unset($this->_session->register);
        }

        $this->view->assign([
            'registerForm' => $form,
        ]);
    }

    public function registerAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->_helper->redirector('signup', 'index', 'account');
        }
        $form = new Account_Form_Register([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'register',
            ], null, true),
        ]);
        if (! $form->isValid($this->getRequest()->getPost())) {
            $this->_session->register = serialize($form);
            return $this->_helper->redirector('signup', 'index', 'account');
        }

        try {
            $account = new Account_Model_Account($form->getValues());
            $account->setPassword(Account_Model_Account::generatePasswordHash($account->getPassword()));
            $account->setToken(Account_Model_Account::generateToken());

            $accountMapper = new Account_Model_AccountMapper();
            $accountMapper->save($account);
        } catch (Exception $exception) {
            $form->getElement('email')->addErrorMessage('Email was already registered');
            $this->_session->register = serialize($form);
            return $this->_helper->redirector('signup', 'index', 'account');
        }

        $name = sprintf('%s %s', $account->getFirstName(), $account->getLastName());
        $link = sprintf(
            'https://%s/%s?token=%s&email=%s',
            isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'training.local',
            'account/index/confirm-signup',
            $account->getToken(),
            urlencode($account->getEmail())
        );

        $html = file_get_contents(APPLICATION_PATH . "/templates/register.html");
        $text = file_get_contents(APPLICATION_PATH . "/templates/register.txt");

        $html = str_replace('{{NAME}}', $name, $html);
        $html = str_replace('{{LINK}}', $link, $html);

        $text = str_replace('{{NAME}}', $name, $text);
        $text = str_replace('{{LINK}}', $link, $text);

        $mail = new Zend_Mail();
        $mail->setFrom('register@theialive.com', 'TheiaLive Registration');
        $mail->addTo($account->getEmail(), sprintf('%s %s', $account->getFirstName(), $account->getLastName()));
        $mail->setSubject('Complete your registration at TheiaLive');
        $mail->setBodyHtml($html);
        $mail->setBodyText($text);
        $result = false;
        try {
            $result = $mail->send();
        } catch (Exception $exception) {
        }
        $this->_session->name = $name;
        return $this->_helper->redirector('registration-success', 'index', 'account');
        // action body
    }

    public function registrationSuccessAction()
    {
        if (! isset($this->_session->name)) {
            return $this->_helper->redirector('signup', 'index', 'account');
        }
        $this->view->name = $this->_session->name;
        unset($this->_session->name);
    }

    public function confirmSignupAction()
    {
        $token = $this->getRequest()->getParam('token', null);
        $email = $this->getRequest()->getParam('email', null);
        if (null === $token || null === $email) {
            return $this->_helper->redirector('invalid-signup', 'index', 'account');
        }
        $account = new Account_Model_Account();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->fetchRow($account, [
            'token = ?' => $token,
            'email = ?' => $email,
        ]);
        if (0 === (int) $account->getId()) {
            return $this->_helper->redirector('invalid-signup', 'index', 'account');
        }
        $account->setActive(true);
        $account->setToken(null);
        $account->setModified(new DateTime('now'));
        $accountMapper->save($account);
        return $this->_helper->redirector('login', 'index', 'account');
    }

    public function invalidSignupAction()
    {
        // action body
    }

    public function loginAction()
    {
        $form = new Account_Form_Login([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'authenticate',
            ], null, true),
        ]);

        if (isset($this->_session->login)) {
            $form = unserialize($this->_session->login);
            unset($this->_session->login);
        }

        $this->view->assign([
            'loginForm' => $form,
        ]);
    }

    public function authenticateAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->_helper->redirector('login', 'index', 'account');
        }
        $form = new Account_Form_Login([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'authenticate',
            ], null, true),
        ]);
        if (! $form->isValid($this->getRequest()->getPost())) {
            $this->_session->login = serialize($form);
            return $this->_helper->redirector('login', 'index', 'account');
        }

        $bootstrap = $this->getInvokeArg('bootstrap');
        $bootstrap->bootstrap('db');
        $dbAdapter = $bootstrap->getResource('db');

        $auth = Zend_Auth::getInstance();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('account')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('? AND `active` = 1');

        $authAdapter->setIdentity($form->getValue('email'));
        $authAdapter->setCredential(Account_Model_Account::generatePasswordHash($form->getValue('password')));

        $result = $auth->authenticate($authAdapter);
        if (! $result->isValid()) {
            $form->getElement('email')->addError('Invalid username and/or password provided');
            $this->_session->login = serialize($form);
            return $this->_helper->redirector('login', 'index', 'account');
        }
        $account = new Account_Model_Account($authAdapter->getResultRowObject());
        $storage = $auth->getStorage();
        $storage->write(serialize($account));
        return $this->_helper->redirector('list', 'index', 'project');
    }

    public function forgotPasswordAction()
    {
        $form = new Account_Form_Forgot([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'reset-password',
            ]),
        ]);

        if (isset($this->_session->forgot)) {
            $form = unserialize($this->_session->forgot);
            unset($this->_session->forgot);
        }
        $this->view->assign([
            'forgotForm' => $form,
        ]);
    }

    public function resetPasswordAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->_helper->redirector('forgot-password', 'index', 'account');
        }
        $form = new Account_Form_Forgot([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'reset-password',
            ]),
        ]);
        if (! $form->isValid($this->getRequest()->getPost())) {
            $this->_session->forgot = serialize($form);
            return $this->_helper->redirector('forgot-password', 'index', 'account');
        }

        $account = new Account_Model_Account();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->fetchRow($account, ['email LIKE ?' => $form->getElement('email')->getValue()]);

        if (0 === (int) $account->getId()) {
            $form->getElement('email')->addError('Provided e-mail address does not exists');
            $this->_session->forgot = serialize($form);
            return $this->_helper->redirector('forgot-password', 'index', 'account');
        }

        if (false === $account->isActive()) {
            $form->getElement('email')->addError('Please activate your account before resetting your password');
            $this->_session->forgot = serialize($form);
            return $this->_helper->redirector('forgot-password', 'index', 'account');
        }

        $account->setToken(Account_Model_Account::generateToken());
        $account->setReset(true);
        $accountMapper->save($account);

        $name = sprintf('%s %s', $account->getFirstName(), $account->getLastName());
        $link = sprintf(
            'https://%s/%s?token=%s&email=%s',
            isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'training.local',
            'account/index/verify-token',
            $account->getToken(),
            urlencode($account->getEmail())
        );

        $html = file_get_contents(APPLICATION_PATH . '/templates/reset.html');
        $text = file_get_contents(APPLICATION_PATH . '/templates/reset.txt');

        $html = str_replace('{{NAME}}', $name, $html);
        $html = str_replace('{{LINK}}', $link, $html);

        $text = str_replace('{{NAME}}', $name, $text);
        $text = str_replace('{{LINK}}', $link, $text);

        $mail = new Zend_Mail();
        $mail->setFrom('register@theialive.com', 'TheiaLive registration');
        $mail->addTo($account->getEmail(), sprintf('%s %s', $account->getFirstName(), $account->getLastName()));
        $mail->setSubject('Complete your request for a new password');
        $mail->setBodyHtml($html);
        $mail->setBodyText($text);
        $mail->send();
        return $this->_helper->redirector('reset-success', 'index', 'account');
    }

    public function resetSuccessAction()
    {
        // action body
    }

    public function verifyTokenAction()
    {
        $token = $this->getRequest()->getParam('token', null);
        $email = $this->getRequest()->getParam('email', null);

        if (null === $token || null === $email) {
            return $this->_helper->redirector('invalid-request', 'index', 'account');
        }

        $account = new Account_Model_Account();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->fetchRow($account, [
            'email LIKE ?' => $email,
            'token LIKE ?' => $token,
            'reset = ?' => 1,
        ]);
        if (0 === (int) $account->getId()) {
            return $this->_helper->redirector('invalid-request', 'index', 'account');
        }
        $this->_session->tokenCheck = ['email' => $email, 'token' => $token];
        return $this->_helper->redirector('new-password', 'index', 'account');
    }

    public function newPasswordAction()
    {
        if (! isset($this->_session->tokenCheck)) {
            return $this->_helper->redirector('new-password', 'index', 'account');
        }
        $form = new Account_Form_NewPassword([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'save-password',
            ]),
        ]);
        $check = $this->_session->tokenCheck;
        $form->getElement('email')->setValue($check['email']);
        $form->getElement('token')->setValue($check['token']);

        if (isset($this->_session->password)) {
            $form = unserialize($this->_session->password);
            unset($this->_session->password);
        }

        $this->view->assign([
            'newPasswordForm' => $form,
        ]);
    }

    public function savePasswordAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->_helper->redirector('forgot-password', 'index', 'account');
        }
        $form = new Account_Form_NewPassword([
            'method' => 'post',
            'action' => $this->view->url([
                'module' => 'account',
                'controller' => 'index',
                'action' => 'save-Password',
            ]),
        ]);
        if (! $form->isValid($this->getRequest()->getPost())) {
            $this->_session->password = serialize($form);
            return $this->_helper->redirector('forgot-password', 'index', 'account', [
                'email' => $form->getElement('email')->getValue(),
                'token' => $form->getElement('token')->getValue(),
            ]);
        }

        $account = new Account_Model_Account();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->fetchRow($account, [
            'email = ?' => $form->getElement('email')->getValue(),
            'token = ?' => $form->getElement('token')->getValue(),
        ]);
        if (0 === (int) $account->getId()) {
            $form->getElement('password')->addError('Password wasn\'t validated');
            $this->_session->password = serialize($form);
            return $this->_helper->redirector('forgot-password', 'index', 'account', [
                'email' => $form->getElement('email')->getValue(),
                'token' => $form->getElement('token')->getValue(),
            ]);
        }
        $account->setPassword(Account_Model_Account::generatePasswordHash(
            $form->getElement('password')->getValue()
        ));
        $account->setToken(null);
        $accountMapper->save($account);

        return $this->_helper->redirector('login', 'index', 'account');
    }

    public function signoffAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
        }
        return $this->_helper->redirector('signoff-success', 'index', 'account');
    }

    public function signoffSuccessAction()
    {
        // action body
    }

    public function invalidRequestAction()
    {
        // action body
    }
}
