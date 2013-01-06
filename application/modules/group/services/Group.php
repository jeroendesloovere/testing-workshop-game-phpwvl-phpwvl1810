<?php

class Group_Service_Group
{
    public function createGroup(Application_Model_Account $account, $label)
    {
        $group = new Application_Model_Group();
        $groupMapper = new Application_Model_GroupMapper();
        
        $group->setGroupName($label);
        
        $groupMapper->save($group);
        
        $groupAccount = new Application_Model_GroupAccount();
        $groupAccountMapper = new Application_Model_GroupAccountMapper();
        
        $groupAccount->setGroupId($group->getId())
                     ->setAccountId($account->getId());
        
        $groupAccountMapper->save($groupAccount);
    }
}