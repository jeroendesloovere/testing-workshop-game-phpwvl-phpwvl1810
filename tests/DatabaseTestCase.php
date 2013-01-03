<?php
require_once 'Zend/Application.php';
require_once 'Zend/Test/PHPUnit/DatabaseTestCase.php';
require_once 'PHPUnit/Extensions/Database/DataSet/FlatXmlDataSet.php';

abstract class DatabaseTestCase extends Zend_Test_PHPUnit_DatabaseTestCase
{
    private $_dbMock;
    private $_application;
    
    protected function setUp()
    {
        $this->_application = new Zend_Application(
            APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }
    public function appBootstrap()
    {
        $this->_application->bootstrap();
    }
    protected function getConnection()
    {
        if (null === $this->_dbMock) {
            $bootstrap = $this->_application->getBootstrap();
            $bootstrap->bootstrap('db');
            $connection = $bootstrap->getResource('db');
            
            $this->_dbMock = $this->createZendDbConnection($connection,'theiatest');
            Zend_Db_Table_Abstract::setDefaultAdapter($connection);
        }
        return $this->_dbMock;
    }
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(
            dirname(__FILE__) . '/_files/initialDataset.xml');
    }
}