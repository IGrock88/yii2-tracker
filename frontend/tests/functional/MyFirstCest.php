<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class MyFirstCest
{

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @dataProvider pageProvider
     */
    public function checkTextInH1Tags(FunctionalTester $I, \Codeception\Example $example)
    {
        $I->amOnPage($example['url']);
        $I->see($example['text'], 'h1');

    }

    /**
     * @return array
     */
    protected function pageProvider()
    {
        return [
            ['url'=>"/site/index", 'text'=>"Congratulations!"],
            ['url'=>"/site/about", 'text'=>"About"],
            ['url'=>"/site/contact", 'text'=>"Contact"],
            ['url'=>"/site/signup", 'text'=>"Signup"],
            ['url'=>"/site/login", 'text'=>"Login"],
            ['url'=>"/hello/index", 'text'=>"Hello, World!"]
        ];
    }
}
