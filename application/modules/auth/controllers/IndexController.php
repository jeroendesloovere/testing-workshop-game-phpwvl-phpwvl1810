<?php

class Auth_IndexController extends Zend_Controller_Action
{
    protected $_session;
    
    public function init()
    {
        $this->_session = new Zend_Session_Namespace('application_auth');
    }

    public function indexAction()
    {
        $form = $this->_getForm('login');
        if (isset ($this->_session->loginForm)) {
            $form = unserialize($this->_session->loginForm);
            unset ($this->_session->loginForm);
        }
        $this->view->assign(array (
            'warning' => $this->_helper->flashMessenger->getMessages(),
            'form' => $form,
        ));
    }

    public function loginAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index', 'index', 'auth');
        }
        
        $form = $this->_getForm('login');
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->loginForm = serialize($form);
            return $this->_helper->redirector('index', 'index', 'auth');
        }
        
        $values = $form->getValues();
        
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Application_Model_Auth($values['email'], $values['password']);
        
        $bootstrap = $this->getInvokeArg('bootstrap');
        $bootstrap->bootstrap('db');
        $dbAdapter = $bootstrap->getResource('db');
        
        $authAdapter->setDbAdapter($dbAdapter);
        $result = $auth->authenticate($authAdapter);
        
        if (!$result->isValid()) {
            $this->_helper->flashMessenger->addMessage('Invalid username and/or password');
            $this->_session->loginForm = serialize($form);
            return $this->_helper->redirector('index', 'index', 'auth');
        }
        $storage = $auth->getStorage();
        $account = new Application_Model_Account($authAdapter->getResultRowObject());
        $storage->write(serialize($account));
        
        return $this->_helper->redirector('index', 'index', 'default');
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_helper->redirector('index', 'index', 'default');
    }

    public function signupAction()
    {
        $form = $this->_getForm('register');
        if (isset ($this->_session->registerForm)) {
            $form = unserialize($this->_session->registerForm);
            unset ($this->_session->registerForm);
        }
        $this->view->assign(array ('form' => $form));
    }

    public function registerAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('signup', 'index', 'auth');
        }
        $form = $this->_getForm('register');
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->registerForm = serialize($form);
            return $this->_helper->redirector('signup', 'index', 'auth');
        }
        $data = $form->getValues();

        $service = new Auth_Service_Account();
        $result = $service->registerNewAccount($data);
    }

    public function forgotAction()
    {
        // action body
    }

    public function resetAction()
    {
        // action body
    }

    protected function _getForm($formType)
    {
        $form = null;
        switch ($formType) {
            case 'login':
                $form = new Auth_Form_Login(array (
                    'method' => 'post',
                    'action' => $this->view->url(array (
                        'module' => 'auth',
                        'controller' => 'index',
                        'action' => 'login',
                    ), null, true),
                ));
                break;
            case 'register':
                $form = new Auth_Form_Register(array (
                    'method' => 'post',
                    'action' => $this->view->url(array (
                        'module' => 'auth',
                        'controller' => 'index',
                        'action' => 'register',
                    ), null, true),
                ));
                break;
            case 'forgot':
                break;
            default:
                break;
        }
        return $form;
    }
}
