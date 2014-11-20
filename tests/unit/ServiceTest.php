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
		$service = new \Ovide\Lib\Translate\Service();

		$service->attachAdapter('db', Mocks\TranslationArray::class);
		$this->assertInstanceOf(Mocks\TranslationArray::class, $service->getAdapterFor('FooModel'));
		$service->bindModelConnection('db', 'FooModel');
		$this->assertInstanceOf(Mocks\TranslationArray::class, $service->getAdapterFor('FooModel'));
    }

	public function testGetDi()
	{
		$service = new \Ovide\Lib\Translate\Service();
		$service->setDI($this->di);
		$this->assertSame($this->di, $service->getDI());
	}

}