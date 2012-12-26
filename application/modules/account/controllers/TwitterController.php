<?php

class Account_TwitterController extends Zend_Controller_Action
{

    protected $_session = null;
    protected $_config = null;

    public function init()
    {
        $this->_session = new Zend_Session_Namespace('twitter');
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/api.ini', APPLICATION_ENV);
    }

    public function indexAction()
    {
        if (!isset ($this->_session->TWITTER_ACCESS_TOKEN)) {
            return $this->_helper->redirector('authenticate', 'twitter', 'account');
        }
        $account = unserialize($this->_session->TWITTER_ACCESS_TOKEN);
        
        $twitter = new Zend_Service_Twitter(array (
            'consumerKey' => $this->_config->twitter->consumerKey,
            'consumerSecret' => $this->_config->twitter->consumerSecret,
            'username' => $account->screen_name,
            'accessToken' => $account,
        ));
        
        $response = $twitter->accountVerifyCredentials();
        $this->view->assign(array (
            'account' => $account,
            'profile' => $response,
        ));
    }

    public function callbackAction()
    {
        $consumer = new Zend_Oauth_Consumer($this->_config->twitter);
 
        if (!empty($_GET) && isset($this->_session->TWITTER_REQUEST_TOKEN)) {
            $token = $consumer->getAccessToken(
                         $_GET,
                         unserialize($this->_session->TWITTER_REQUEST_TOKEN)
                     );
            $this->_session->TWITTER_ACCESS_TOKEN = serialize($token);

            // Now that we have an Access Token, we can discard the Request Token
            $this->_session->TWITTER_REQUEST_TOKEN = null;
            return $this->_helper->redirector('index', 'twitter', 'account');
            
        } else {
            // Mistaken request? Some malfeasant trying something?
            echo 'Invalid callback request. Oops. Sorry.';
            
            Zend_Debug::dump($_SESSION,'$_SESSION');
            Zend_Debug::dump($_GET, '$_GET');
        }
    }

    public function authenticateAction()
    {
        $consumer = new Zend_Oauth_Consumer($this->_config->twitter);

        // fetch a request token
        $token = $consumer->getRequestToken();

        // persist the token to storage
        $this->_session->TWITTER_REQUEST_TOKEN = serialize($token);

        // redirect the user
        $consumer->redirect();
    }


}





