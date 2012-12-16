<?php

class Application_View_Helper_AccountSettings extends Zend_View_Helper_Abstract
{
    protected $_view;
    
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    public function accountSettings()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return $this->_view->render('account.phtml');
        } else {
            return $this->_view->render('anonymous.phtml');
        }
    }
}