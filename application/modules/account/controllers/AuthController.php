<?php

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
                    'action' => $this->view->Url(array (
                        'module' => 'account',
                        'controller' => 'auth',
                        'action' => 'login',
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
        // action body
    }

    public function registerAction()
    {
        // action body
    }


}









