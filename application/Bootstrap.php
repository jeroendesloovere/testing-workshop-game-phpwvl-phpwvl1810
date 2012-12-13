<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initViewSetup()
    {
        // Initialize view
        $view = $this->getPluginResource('view')->getView();
        $view->headMeta()->setHttpEquiv(
            'text/html; Charset=UTF-8', 'Content-Type'
        );
        $view->headTitle('TheiaLive');
        $view->headTitle()->setSeparator(' | ');
        $view->headLink()->appendStylesheet($view->baseUrl('/style/main.css'));
        $view->headLink()->appendStylesheet($view->baseUrl('/jquery/css/redmond/jquery-ui-1.8.21.custom.css'));
        $view->headLink()->appendStylesheet('http://fonts.googleapis.com/css?family=Exo');
        $view->headScript()->appendFile($view->baseUrl('/jquery/js/jquery-1.7.2.min.js'));
        $view->headScript()->appendFile($view->baseUrl('/jquery/js/jquery-ui-1.8.21.custom.min.js'));
        
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
        
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

}

