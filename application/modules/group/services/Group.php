<?php

class Group_Service_Group
{
    public function createGroup(Application_Model_Account $account, $label)
    {
        if (0 === (int) $account->getId()) {
            return false;
        }
        $group = new Application_Model_Group();
        $groupMapper = new Application_Model_GroupMapper();
        
        $group->setGroupName($label);
        try {
            $groupMapper->save($group);
        } catch (Zend_Db_Exception $exception) {
            return false;
        }
        
        $groupAccount = new Application_Model_GroupAccount();
        $groupAccountMapper = new Application_Model_GroupAccountMapper();
        
        $groupAccount->setGroupId($group->getId())
                     ->setAccountId($account->getId());
        try {
            $groupAccountMapper->save($groupAccount);
        } catch (Zend_Db_Exception $exception) {
            return false;
        }
        return true;
    }
}