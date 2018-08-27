<?php
namespace frontend\tests;

use frontend\models\ContactForm;
use yii\swiftmailer\Message;

class MyFirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests

    public function testAssertTrue()
    {
        $this->assertTrue(5 < 6, '5 меньше 6');
    }

    public function testAssertEqualTest()
    {
        $a = 6;
        $b = 6;
        $this->assertEquals($a, $b, "$a равно $b");
    }

    public function testAssertLessThanTest()
    {
        $a = 7;
        $b = 6;
        $this->assertLessThan($a, $b, "$a меньше $b");
    }

    public function testAssertArrayHasKeyTest()
    {
        $testArray = [
            'name' => 'James',
            'email' => 'james@gmail.com',
            'subject' => 'error',
            'body' => 'Does not work everything'];
        $key = 'name';
        $this->assertArrayHasKey($key, $testArray, "$key есть в массиве");
    }


    public function testAssertAttributeEquals()
    {
        $testArray = [
            'name' => 'James',
            'email' => 'james@gmail.com',
            'subject' => 'error',
            'body' => 'Does not work everything'];

        $contactForm = new ContactForm($testArray);

        foreach ($testArray as $key => $item){
            $this->assertAttributeEquals($item, $key, $contactForm);
        }
    }
}