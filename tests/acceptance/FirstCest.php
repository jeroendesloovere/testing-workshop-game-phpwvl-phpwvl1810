<?php 

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('The easy task manager');
    }


    public function contactUsLinkWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('The easy task manager');
        $I->click('contact us');
        $I->see('Contact us');
        $I->see('Your name');
    }
}
