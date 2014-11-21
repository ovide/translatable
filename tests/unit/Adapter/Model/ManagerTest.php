<?php namespace Adapter\Model;


class ManagerTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

	/**
	 * @var \Phalcon\DiInterface
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

		$this->di->set('backendModel', \Mocks\Translation1::class);
		$translator = $this->getMock(Ovide\Lib\Translate\Service::class, ['getAdapterFor']);

		$translator->method('getAdapterFor')->willReturn([
			'manager' => \Ovide\Lib\Translate\Adapter\Model\Manager::class,
			'options' => ['backendModel' => get_class($this->di->getService('backendModel')->resolve())]
		]);

		$this->di->setShared('translator', $translator);
    }

    protected function _after()
    {
		$this->di->reset();
    }

    public function testRetrieve()
    {
		try {
			\Ovide\Lib\Translate\Adapter\Model\Manager::retrieve(new \Mocks\Basic(), ['id']);
			$this->assertTrue(false, "LogicException was expected");
		} catch (\LogicException $ex) {
			$this->assertEquals('backendModel must be given', $ex->getMessage());
		}
		$backendInstance  = $this->di->get('backendModel');
		$backendClassName = get_class($backendInstance);
		$manager = \Ovide\Lib\Translate\Adapter\Model\Manager::retrieve(
				new \Mocks\Basic(),
				['id'],
				['backendModel' => $backendClassName]
		);

		$this->assertInstanceOf(\Ovide\Lib\Translate\Adapter\Model\Manager::class, $manager);
    }

	public function testGet()
	{
		$I = $this->tester;

		$expected = 'hi there';
		$record   = 1;
		$field    = 'name';
		$language = 'en';

		$I->haveInDatabase('basic', ['id' => $record]);
		$I->haveInDatabase('translation', [
			'table' => \Mocks\Basic::SRC_TABLE,
			'field' => $field,
			'row'   => $record,
			'lang'  => $language,
			'text'  => $expected
		]);

		$backendInstance  = $this->di->get('backendModel');
		$backendClassName = get_class($backendInstance);
		$model = \Mocks\Basic::findFirst(1);
		$manager = \Ovide\Lib\Translate\Adapter\Model\Manager::retrieve(
				$model,
				['id'],
				['backendModel' => $backendClassName]
		);

		$this->assertEquals($expected, $manager->get($field, $language));

		$this->assertEmpty($manager->get($field, 'foo'));

		$empty = new \Mocks\Basic();
		$manager2 = \Ovide\Lib\Translate\Adapter\Model\Manager::retrieve(
				$empty,
				['id'],
				['backendModel' => $backendClassName]
		);
		$this->assertEmpty($manager2->get($field, $language));
	}

	public function testSet()
	{

	}

	public function testPersist()
	{

	}

	public function testRemove()
	{

	}
}
