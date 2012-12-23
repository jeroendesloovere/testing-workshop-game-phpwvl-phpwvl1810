<?php

class Project_Service_Project
{
    public function getAllProjects(Application_Model_Account $account)
    {
        $projectCollection = new Application_Model_ProjectCollection();
        $projectMapper = new Application_Model_ProjectMapper();
        $projectMapper->fetchAll(
                $projectCollection, 
                'Application_Model_Project',
                array (
                    'accountId = ?' => $account->getId(),
                    'accountToken = ?' => $account->getToken(),
                ));
        
        return $projectCollection;
    }
}