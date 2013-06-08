<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class TestCase extends PHPUnit_Extensions_SeleniumTestCase
{
    //const TEST_HUB = '217.21.179.192';
    const TEST_HUB = '192.168.56.101';
    const TEST_PORT = 12666;

    const USERNAME = 'dragonbe+tek13@gmail.com';
    const PASSWORD = 'test1234';
    const BASURL = 'http://www.theialive.com';

    public static $browsers = array (
        array (
            'name' => 'Internet Explorer 8 on Windows 7',
            'browser' => '*iexplore',
            'host' => self::TEST_HUB,
            'port' => self::TEST_PORT,
        ),
        array (
            'name' => 'Firefox on Windows 7',
            'browser' => '*firefox',
            'host' => self::TEST_HUB,
            'port' => self::TEST_PORT,
        ),
        array (
            'name' => 'Google Chrome on Windows 7',
            'browser' => '*googlechrome',
            'host' => self::TEST_HUB,
            'port' => self::TEST_PORT,
        ),
    );

    protected function setUp()
    {
        $this->setBrowserUrl(self::BASURL);
    }
}
