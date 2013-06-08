<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initViewSetup()
    {
        // Initialize view
        if (null !== $this->getPluginResource('view')) {
            $view = $this->getPluginResource('view')->getView();
        } else {
            $view = new Zend_View();
        }
        $view->headMeta()->setHttpEquiv(
            'Content-Type', 'text/html; Charset=UTF-8'
        );
        $view->headTitle('TheiaLive');
        $view->headTitle()->setSeparator(' | ');
        $view->headLink()->appendStylesheet($view->baseUrl('/styles/main.css'));
        $view->headLink()->appendStylesheet('http://fonts.googleapis.com/css?family=Exo');
        $view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
        
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
        
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

}

