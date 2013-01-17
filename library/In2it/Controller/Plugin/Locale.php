<?php
/**
 * In2it Framework
 * 
 * Extends Zend Framework with custom functionality or overriding ZF 
 * functionality matching needs of the application
 * 
 * @category    In2it
 * @package     In2it
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
/**
 * In2it_Controller_Plugin_Locale
 * 
 * This class runs as plugin to assist making web applications support multiple
 * languages.
 * 
 * @category   In2it
 * @package    In2it_Controller
 * @subpackage Plugin
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
class In2it_Controller_Plugin_Locale extends Zend_Controller_Plugin_Abstract
{
    /**
     * Multi-linguality starts at pre-dispatch
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @see Zend_Controller_Plugin_Abstract::preDispatch()
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $lang = $this->getRequest()->getParam('lang', false);
        $session = new Zend_Session_Namespace('Zend_Locale');
        if (false === $lang) {
            $lang = (!isset ($session->lang) ? 'en' : $session->lang);
        }
        $session->lang = $lang;
        $translate = Zend_Registry::get('Zend_Translate');
        
        
        $translate->setLocale(new Zend_Locale($lang));
        Zend_Registry::set('Zend_Translate', $translate);
        $this->getRequest()->setParam('lang', $session->lang);
    }
    
}