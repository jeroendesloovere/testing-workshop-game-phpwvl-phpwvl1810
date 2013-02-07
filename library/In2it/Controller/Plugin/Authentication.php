<?php

class In2it_Controller_Plugin_Authentication extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
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