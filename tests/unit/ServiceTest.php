<?php


class ServiceTest extends \Codeception\TestCase\Test
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    protected $di;

    protected function _before()
    {
        $this->di = new \Phalcon\DI();
    }

    protected function _after()
    {
    }

    // tests
    public function testAttachAdapter()
    {
        $service  = new \Ovide\Lib\Translate\Service();
        $expected = ['manager' => Mocks\TranslationArray::class, 'options' => null];

        $service->attachAdapter('db', Mocks\TranslationArray::class);
        $this->assertEquals($expected, $service->getAdapterFor('FooModel'));
        $service->bindModelConnection('db', 'FooModel');
        $this->assertEquals($expected, $service->getAdapterFor('FooModel'));
    }
}
