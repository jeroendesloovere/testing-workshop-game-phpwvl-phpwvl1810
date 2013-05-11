<?php
/**
 * Class Task_IndexControllerTest
 *
 * @group Task_IndexControllerTest
 * @group Task
 */
class Task_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'task');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);

        $this->assertRedirect('Expected redirect not triggered');

        $redirectParams = $this->urlizeOptions(array (
            'action' => 'list', 'controller' => 'index', 'module' => 'task',
        ));
        $redirectUrl = $this->url($redirectParams);
        $this->assertRedirectTo($redirectUrl, 'No redirection to ' . $redirectUrl);
    }

    public function testListAction()
    {
        $params = array('action' => 'list', 'controller' => 'index', 'module' => 'task');
        $params['projectId'] = 1;
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Listing tasks');
        $this->assertQueryCount('tr.tableRow', 1, 'Expecting at least 1 row');
    }

    public function testEditAction()
    {
        $params = array('action' => 'edit', 'controller' => 'index', 'module' => 'task');
        $params['projectId'] = 1;
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h1', 'Add or edit a task');
    }

    public function testSaveAction()
    {
        $params = array('action' => 'save', 'controller' => 'index', 'module' => 'task');
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

    public function testRemoveAction()
    {
        $params = array('action' => 'remove', 'controller' => 'index', 'module' => 'task');
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
    public function testTaskCanBeCompleted()
    {
        $data = array (
            'taskId' => 1,
            'projectId' => 1,
            'accountId' => 1,
            'title' => 'TestTask',
            'description' => 'Lorem lipsum',
            'dueDate' => date('Y-m-d H:i:s'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
            'done' => 1,
        );
        $task = new Task_Model_Task($data);
        $this->assertTrue($task->isDone(),
            'Expected task was done, but it is not');
    }


}











