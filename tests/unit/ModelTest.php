<?php


class ModelTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

	/**
	 * @var \Phalcon\DI
	 */
	protected $di;

    protected function _before()
    {
		$this->di = new \Phalcon\DI();
		$this->di->setShared('modelsManager', \Phalcon\Mvc\Model\Manager::class);
		$this->di->setShared('modelsMetadata', \Phalcon\Mvc\Model\MetaData\Memory::class);
		$this->di->setShared('db', function() {
			return new \Phalcon\Db\Adapter\Pdo\Mysql([
				'host'     => 'localhost',
				'username' => 'translatable',
				'password' => 'translatable',
				'dbname'   => 'translatable'
			]);
		});
    }

    protected function _after()
    {
		$this->di->reset();
    }

    public function testSetLanguageResolver()
	{
		$translator = $this->getMock(\Ovide\Lib\Translate\Service::class);
		$this->di->setShared('translator', $translator);
		$closure = function() {	return 'foo'; };
		Mocks\Basic::setLanguageResolver($closure);
		$reflection = new ReflectionClass(Mocks\Basic::class);
		$resolver = $reflection->getProperty('_langResolver');
		$resolver->setAccessible(true);
		$this->assertSame($closure, $resolver->getValue());
		$model = new Mocks\Basic();
		$this->assertEquals('foo', $model->getCurrentLang());

		//reset
		$resolver->setValue(null, null);
	}

	public function testSetCurrentLang()
	{
		$model = $this->getMockBuilder(Mocks\Basic::class)
				->disableOriginalConstructor()
				->setMethods(null)
				->getMock();
		$model->setCurrentLang('es');
		$this->assertEquals('es', $model->getCurrentLang());
	}

    public function testOnConstruct()
    {
		$translator = $this->getMock(\Ovide\Lib\Translate\Service::class);
		$this->di->setShared('translator', $translator);

		$model = new Mocks\Basic();

		$reflection = new ReflectionObject($model);

		$serviceProp = $reflection->getProperty('_translator');
		$serviceProp->setAccessible(true);
		$service = $serviceProp->getValue($model);

		$translatableProp = $reflection->getProperty('_translatable');
		$translatableProp->setAccessible(true);
		$translatable = $translatableProp->getValue($model);

		$this->assertEquals($translator, $service);
		$this->assertEquals(['name', 'description'], $translatable);
    }

	public function testSetGetFetched()
	{
		$I = $this->tester;
		$I->haveInDatabase('basic', ['id' => 1, 'value' => 'foo']);

		$service = $this->getMock(Ovide\Lib\Translate\Service::class, ['getAdapterFor']);
		$service->method('getAdapterFor')->willReturn(Mocks\TranslationArray::class);

		$this->di->setShared('translator', $service);

		$model = Mocks\Basic::findFirst(1);
		$this->assertEquals('The translated name'       , $model->name);
		$this->assertEquals('The translated description', $model->description);
	}

	public function testSetGetAndSave()
	{
		$service    = $this->getMock(Ovide\Lib\Translate\Service::class, ['getAdapterFor']);
		$service->method('getAdapterFor')->willReturn(Mocks\TranslationArray::class);

		$this->di->setShared('translator', $service);

		$model              = new Mocks\Basic();
		$model->value       = 'value';
		$model->name        = 'foo';
		$model->description = 'bar';
		$this->assertEquals('value', $model->value);
		$this->assertEquals('foo'  , $model->name);
		$this->assertEquals('bar'  , $model->description);

		$model->save();

		$counter = Mocks\TranslationArray::resetCounter();
		$this->assertEquals(1, $counter['persist'], "Method 'persist' not called");
	}

	public function testParentMagicSetter()
	{
		$translator = $this->getMock(stdClass::class);
		$this->di->setShared('translator', $translator);

		$model = $this->getMockBuilder(Mocks\Basic::class)->setMethods(['setTranslation'])->getMock();
		$model->expects($this->never())->method('setTranslation');

		$model->foo = 'bar';
		$this->assertEquals('bar', $model->foo);
	}

	public function testGetTranslatableFields()
	{
		$model = $this->getMockBuilder(Mocks\Basic::class)
				->disableOriginalConstructor()
				->setMethods(null)
				->getMock();
		$fields = $model->getTranslatableFields();
		$this->assertEquals(['name', 'description'], $fields);
	}

	public function testSetReadConnection()
	{
		$this->di->setShared('translator', $this->getMock(\Ovide\Lib\Translate\Service::class));

		$model = new Mocks\Basic();
		$model->setReadConnectionService('db');

		$reflection = new ReflectionObject($model);
		$conRead    = $reflection->getProperty('_conRead');
		$conRead->setAccessible(true);
		$value = $conRead->getValue($model);

		$this->assertEquals('db', $value);
	}

	public function testSetConnectionService()
	{
		$translator = $this->getMockBuilder(\Ovide\Lib\Translate\Service::class)
				->setMethods(['bindModelConnection'])->getMock();
		$translator->expects($this->once())->method('bindModelConnection');
		$this->di->setShared('translator', $translator);

		$model = new Mocks\Basic();
		$model->setConnectionService('db');
	}

	public function testAfterDelete()
	{
		$this->tester->haveInDatabase('basic', ['value' => 'foo']);

		$translator = $this->getMockBuilder(\Ovide\Lib\Translate\Service::class)
				->setMethods(['getAdapterFor'])
				->getMock();

		$translator->method('getAdapterFor')->willReturn(Mocks\TranslationArray::class);
		$this->di->setShared('translator', $translator);

		$model = Mocks\Basic::findFirst();
		$model->delete();

		$counter = Mocks\TranslationArray::resetCounter();

		$this->assertEquals(1, $counter['remove'], "Method 'remove' not called'");
	}
}
