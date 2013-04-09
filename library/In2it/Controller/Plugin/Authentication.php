<?php

class In2it_Controller_Plugin_Authentication extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (APPLICATION_ENV === 'testing') {
            $identity = new Account_Model_Account(array (
                'accountId' => 1,
                'firstName' => 'John',
                'lastName'  => 'Doe',
                'email'     => 'john.doe@example.com',
                'password'  => 'test1234',
                'token'     => '',
                'active'    => 1,
                'reset'     => 0,
                'created'   => '1999-12-31 23:59:59',
                'modified'  => '2000-01-01 00:00:00',
            ));
            Zend_Auth::getInstance()->getStorage()->write(serialize($identity));
        }

        if (!Zend_Auth::getInstance()->hasIdentity()) {
            if ('account' !== $request->getModuleName() && 'index' !== $request->getControllerName()) {
                $request->clearParams();
                $request->setModuleName('account');
                $request->setControllerName('index');
                $request->setActionName('login');
            }
        }
    }
}