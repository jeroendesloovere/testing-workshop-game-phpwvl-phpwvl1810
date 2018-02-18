<?php
/**
 * Class Project_IndexControllerTest
 *
 * @group Project_indexControllerTest
 * @group Project
 */
class Project_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'project');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'list', 'controller' => 'index', 'module' => 'project',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testListAction()
    {
        $params = array('action' => 'list', 'controller' => 'index', 'module' => 'project');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Your current projects');
    }

    public function testEditAction()
    {
        $params = array('action' => 'edit', 'controller' => 'index', 'module' => 'project');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Edit or add a new project');
    }

    public function testSaveAction()
    {
        $params = array('action' => 'save', 'controller' => 'index', 'module' => 'project');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'edit', 'controller' => 'index', 'module' => 'project',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testRemoveAction()
    {
        $params = array('action' => 'remove', 'controller' => 'index', 'module' => 'project');
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


}










