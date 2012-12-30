<?php
/**
 * TheiaLive
 *
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 *
 */

/**
 * Account_AuthController
 *
 * @package Controller
 * @category Auth
 *
 */
class Account_AuthController extends Zend_Controller_Action
{

    protected $_session = null;

    public function init()
    {
        $this->_session = new Zend_Session_Namespace('ApplicationAuth');
    }

    protected function _getForm($type)
    {
        $form = null;
        switch ($type) {
            case 'login':
                $form = new Account_Form_Login(array (
                    'method' => 'post',
                    'action' => $this->view->url(array (
                        'module' => 'account',
                        'controller' => 'auth',
                        'action' => 'login',
                    )),
                ));
                break;
            case 'signup':
                $form = new Account_Form_Signup(array (
                    'method' => 'post',
                    'action' => $this->view->url(array (
                        'module' => 'account',
                        'controller' => 'auth',
                        'action' => 'register',
                    )),
                ));
                break;
            case 'forgot':
                $form = new Account_Form_Forgot(array (
                    'method' => 'post',
                    'action' => $this->view->url(array (
                        'module' => 'account',
                        'controller' => 'auth',
                        'action' => 'reset',
                    ))
                ));
                break;
            case 'newPassword':
                $form = new Account_Form_NewPassword(array (
                    'method' => 'post',
                    'action' => $this->view->url(array (
                        'module' => 'account',
                        'controller' => 'auth',
                        'action' => 'reset-password',
                    )),
                ));
                break;
            default:
                break;
        }
        return $form;
    }

    public function indexAction()
    {
        $form = $this->_getForm('login');
        
        if (isset ($this->_session->loginForm)) {
            $form = unserialize($this->_session->loginForm);
            unset ($this->_session->loginForm);
        }
        
        $this->view->assign(array (
            'loginForm' => $form,
        ));
    }

    public function loginAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index', 'auth', 'account');
        }
        $form = $this->_getForm('login');
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->loginForm = serialize($form);
            return $this->_helper->redirector('index', 'auth', 'account');
        }
        
        $values = $form->getValues();
        
        // get the database adapter to feed to the service
        $bootstrap = $this->getInvokeArg('bootstrap');
        $bootstrap->bootstrap('db');
        $dbAdapter = $bootstrap->getResource('db');
        
        $service = new Account_Service_Auth($dbAdapter);
        $result = $service->authenticate($values['email'], $values['password']);
        
        if (false === $result) {
            $form->getElement('email')->addError('Invalid email and/or password provided');
            $this->_session->loginForm = serialize($form);
            return $this->_helper->redirector('index', 'auth', 'account');
        }
        return $this->_helper->redirector('index', 'index', 'default');
    }

    public function logoutAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
        }
        return $this->_helper->redirector('index', 'index', 'default');
    }

    public function signupAction()
    {
        $form = $this->_getForm('signup');
        
        if (isset ($this->_session->signupForm)) {
            $form = unserialize($this->_session->signupForm);
            unset ($this->_session->signupForm);
        }
        $this->view->assign(array (
            'signupForm' => $form,
        ));
    }

    public function registerAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('signup', 'auth', 'account');
        }
        $form = $this->_getForm('signup');
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->signupForm = serialize($form);
            return $this->_helper->redirector('signup', 'auth', 'account');
        }
        $service = new Account_Service_Auth();
        $service->registerAccount($form->getValues());
        
        return $this->_helper->redirector('confirmation', 'auth', 'account');
    }

    public function confirmationAction()
    {
        // action body
    }

    public function verifyAction()
    {
        $token = $this->getRequest()->getParam('token', null);
        if (null === $token) {
            return $this->_helper->redirector('signup', 'auth', 'account');
        }
        
        $service = new Account_Service_Auth();
        if (!$service->tokenExists($token)) {
            return $this->_helper->redirector('invalid-token', 'auth', 'account');
        }
        
        $service->verifyAccountByToken($token);
        return $this->_helper->redirector('index', 'auth', 'account');
        
    }

    public function forgotAction()
    {
        $form = $this->_getForm('forgot');
        
        if (isset ($this->_session->formForgot)) {
            $form = unserialize($this->_session->formForgot);
            unset ($this->_session->formForgot);
        }
        
        $this->view->assign(array (
            'formForgot' => $form,
        ));
    }

    public function resetAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('forgot', 'auth', 'account');
        }
        $form = $this->_getForm('forgot');
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->formForgot = serialize($form);
            return $this->_helper->redirector('forgot', 'auth', 'account');
        }
        
        $service = new Account_Service_Auth();
        $account = $service->findAccountByEmail($form->getValue('email'));
        
        if (0 === (int) $account->getId()) {
            $form->getElement('email')->addError('Invalid email address provided');
            $this->_session->formForgot = serialize($form);
            return $this->_helper->_redirector('forgot', 'auth', 'account');
        }
        
        $service->resetAccount($account);
    }

    public function newPasswordAction()
    {
        $token = $this->getRequest()->getParam('token', null);
        
        $service = new Account_Service_Auth();
        if (!$service->tokenExists($token)) {
            return $this->_helper->redirector('invalid-token', 'auth', 'account');
        }
        
        $form = $this->_getForm('newPassword');
        
        if (isset ($this->_session->newPasswordForm)) {
            $form = unserialize($this->_session->newPasswordForm);
            unset ($this->_session->newPasswordForm);
        }
        
        if (null !== $token) {
            $form->getElement('token')->setValue($token);
        }
        
        $this->view->assign(array (
            'newPasswordForm' => $form,
        ));
    }

    public function resetPasswordAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index', 'index', 'default');
        }
        $form = $this->_getForm('newPassword');
        
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->newPasswordForm = serialize($form);
            return $this->_helper->redirector('new-password', 'auth', 'account', array ('token' => $form->getValue('token')));
        }
        
        $service = new Account_Service_Auth();
        $result = $service->setNewAccountPassword(
                $form->getValue('password'), $form->getValue('token'));
    }

    public function invalidTokenAction()
    {
        $this->getResponse()->setHttpResponseCode(403);
    }
}