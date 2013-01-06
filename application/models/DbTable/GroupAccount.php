<?php

class Application_Model_DbTable_GroupAccount extends Zend_Db_Table_Abstract
{

    protected $_name = 'groupAccount';
    protected $_primary = array ('groupId', 'accountId');

}

