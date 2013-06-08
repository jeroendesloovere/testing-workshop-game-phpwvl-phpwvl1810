<?php
/**
 * Class MarkTaskDoneTest
 *
 * @group SeleniumTest
 */
require_once 'TestCase.php';
class MarkTaskDoneTest extends TestCase
{
    public function testMarkTestAsDone()
    {
        $this->windowMaximize();
        $this->open("/");
        $this->click("link=login");
        $this->waitForPageToLoad("30000");
        $this->type("id=email", TestCase::USERNAME);
        $this->type("id=password", TestCase::PASSWORD);
        $this->click("id=signin");
        $this->waitForPageToLoad("30000");
        $this->click("link=Test demo");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Done", $this->getText("xpath=//th[5]"));
        $this->click("link=[EDIT]");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isElementPresent("id=done"));
        $this->click("link=sign off");
        $this->waitForPageToLoad("30000");
    }
}
