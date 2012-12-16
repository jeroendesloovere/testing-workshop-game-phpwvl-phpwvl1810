<?php

class Project_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $project = new Project_Service_Project();
        $data = $project->getAllProjects(Zend_Auth::getInstance()->getIdentity());
        
        $this->view->assign(array (
            'projects' => $data,
        ));
    }


}

