<?php
/**
 * Class Account_indexControllerTest
 *
 * @group Account_IndexControllerTest
 * @group Account
 */
class Account_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testindexAction()
    {
        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains(
            'div#view-content p',
            'View script for controller <b>' . $params['controller'] . '</b> and script/action name <b>' . $params['action'] . '</b>'
            );
    }

    public function testSignupAction()
    {
        $params = array('action' => 'signup', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertQueryContentContains('h1', 'Sign up for a new account');
    }

    public function testRegisterAction()
    {
        $params = array('action' => 'register', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'signup', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testLoginAction()
    {
        $params = array('action' => 'login', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Sign in your Theialive account');
    }

    public function testAuthenticateAction()
    {
        $params = array('action' => 'authenticate', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'login', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testForgotPasswordAction()
    {
        $params = array('action' => 'forgotPassword', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Reset your password');
    }

    public function testResetPasswordAction()
    {
        $params = array('action' => 'resetPassword', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'forgot-password', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testConfirmSignupAction()
    {
        $params = array('action' => 'confirmSignup', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'invalid-signup', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testRegistrationSuccessAction()
    {
        $params = array('action' => 'registrationSuccess', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'signup', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testInvalidSignupAction()
    {
        $params = array('action' => 'invalidSignup', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Invalid Signup');
    }

    public function testSignoffAction()
    {
        $params = array('action' => 'signoff', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'signoff-success', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testSignoffSuccessAction()
    {
        $params = array('action' => 'signoffSuccess', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Signed out');
    }

    public function testResetSuccessAction()
    {
        $params = array('action' => 'resetSuccess', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Request reset password successful');
    }

    public function testNewPasswordAction()
    {
        $params = array('action' => 'newPassword', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'new-password', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testInvalidRequestAction()
    {
        $params = array('action' => 'invalidRequest', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains(
            'div#view-content p',
            'View script for controller <b>' . $params['controller'] . '</b> and script/action name <b>' . $params['action'] . '</b>'
            );
    }

    public function testSavePasswordAction()
    {
        $params = array('action' => 'savePassword', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'forgot-password', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testVerifyTokenAction()
    {
        $params = array('action' => 'verifyToken', 'controller' => 'index', 'module' => 'account');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'invalid-request', 'controller' => 'index', 'module' => 'account',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }


}



































