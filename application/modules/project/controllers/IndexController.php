<?php

class Project_IndexController extends Zend_Controller_Action
{
    protected $_session;

    public function init()
    {
        $this->_session = new Zend_Session_Namespace('Project');
    }

    public function indexAction()
    {
        return $this->_helper->redirector('list', 'index', 'project');
    }

    public function listAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $account = unserialize($identity);
        
        $projectCollection = new Project_Model_Collection();
        $projectMapper = new Project_Model_ProjectMapper();
        $projectMapper->fetchAll($projectCollection, 'Project_Model_Project', array (
            'accountId' => $account->getId(),
        ));
        $this->view->projectCollection = $projectCollection;
    }

    public function editAction()
    {
        $projectId = $this->getRequest()->getParam('projectId', null);
        
        $form = new Project_Form_Project(array (
            'method' => 'POST',
            'action' => $this->view->url(array (
                'module' => 'project',
                'controller' => 'index',
                'action' => 'save',
            ), null, true),
        ));
        
        if (null !== $projectId) {
            $identity = Zend_Auth::getInstance()->getIdentity();
            $account = unserialize($identity);
            
            $project = new Project_Model_Project();
            $projectMapper = new Project_Model_ProjectMapper();
            $projectMapper->fetchRow($project, array (
                'projectId = ?' => $projectId,
                'accountId = ?' => $account->getId(),
            ));
            $form->populate($project->toArray());
        }
        
        if (isset ($this->_session->project)) {
            $form = unserialize($this->_session->project);
            unset ($this->_session->project);
        }
        
        $this->view->projectForm = $form;
    }

    public function saveAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('edit', 'index', 'project');
        }
        $form = new Project_Form_Project(array (
            'method' => 'POST',
            'action' => $this->view->url(array (
                'module' => 'project',
                'controller' => 'index',
                'action' => 'save',
            ), null, true),
        ));
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->project = serialize($form);
            return $this->_helper->redirector('edit', 'index', 'project');
        }
        $identity = Zend_Auth::getInstance()->getIdentity();
        $account = unserialize($identity);
        
        $project = new Project_Model_Project($form->getValues());
        $project->setAccountId($account->getId());
        $projectMapper = new Project_Model_ProjectMapper();
        $projectMapper->save($project);
        return $this->_helper->redirector('list', 'index', 'project');
    }

    public function removeAction()
    {
        // action body
    }


}









