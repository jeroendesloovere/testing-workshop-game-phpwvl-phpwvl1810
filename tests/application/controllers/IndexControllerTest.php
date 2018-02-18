<?php
/**
 * Class IndexControllerTest
 *
 * @group Application
 * @group Application_IndexController
 */
class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Watch and learn');
    }

    public function testContactAction()
    {
        $params = array('action' => 'contact', 'controller' => 'index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Contact us');
    }

    public function testSubmitAction()
    {
        $params = array('action' => 'submit', 'controller' => 'index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectUrlParams = $this->urlizeOptions(array (
            'action' => 'contact', 'controller' => 'index', 'module' => 'default',
        ));
        $redirectUrl = $this->url($redirectUrlParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testFailedSubmitReturnsForm()
    {
        $params = array('action' => 'submit', 'controller' => 'index', 'module' => 'default');

        $badData = array (
            'name' => 'test123',
            'email' => 'test123',
            'comment' => '',
        );
        $this->getRequest()->setMethod('POST')
                           ->setPost($badData);

        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectUrlParams = $this->urlizeOptions(array (
            'action' => 'contact', 'controller' => 'index', 'module' => 'default',
        ));
        $redirectUrl = $this->url($redirectUrlParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);

        $this->resetRequest();
        $this->resetResponse();

        $this->dispatch($redirectUrl);
        $this->assertXpathContentContains('//dd[@id="email-element"]/ul[@class="errors"]/li', sprintf(
            "'%s' is not a valid email address in the basic format local-part@hostname",
            $badData['email']
        ), 'Did not detect error message');
    }

    public function testSuccessAction()
    {
        $params = array('action' => 'success', 'controller' => 'index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertQueryContentContains('h1', 'We will contact you');
    }
}








