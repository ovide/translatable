<?php namespace Adapter\Collection;


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
		$this->di->setShared('collectionManager', \Phalcon\Mvc\Collection\Manager::class);
		$this->di->setShared('db', function() {
			return new \Phalcon\Db\Adapter\Pdo\Mysql([
				'host'     => 'localhost',
				'username' => 'translatable',
				'password' => 'translatable',
				'dbname'   => 'translatable'
			]);
		});

		$this->di->setShared('mongo', function() {
			$mongo = new \MongoClient('mongodb://127.0.0.1:27017');
			return $mongo->selectDB("translatable");
		});

		$translator = $this->getMock(Ovide\Lib\Translate\Service::class, ['getAdapterFor']);

		$translator->method('getAdapterFor')->willReturn([
			'manager' => \Ovide\Lib\Translate\Adapter\Collection\Manager::class
		]);

		$this->di->setShared('translator', $translator);
    }

    protected function _after()
    {
		$this->di->reset();
    }

    public function testRetrieve()
    {
		$manager = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve(
				new \Mocks\Basic(),
				['id']
		);

		$this->assertInstanceOf(\Ovide\Lib\Translate\Adapter\Collection\Manager::class, $manager);
    }

	public function testGet()
	{
		$I = $this->tester;

		$expected = 'foo bar';
		$record   = 1;
		$field    = 'name';
		$language = 'en';

		$I->haveInDatabase('basic', ['id' => $record]);
		$I->haveInCollection('translation', [
			'db'       => 'db',
			'table'    => \Mocks\Basic::SRC_TABLE,
			'row'      => "$record",
			'language' => [
				$language => [
					$field => $expected
				]
			]
		]);


		$model = \Mocks\Basic::findFirst(1);
		$manager = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($model, ['id']);

		$this->assertEquals($expected, $manager->get($field, $language));

		$this->assertEmpty($manager->get($field, 'foo'));

		$empty = new \Mocks\Basic();
		$manager2 = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($empty, ['id']);
		$this->assertEmpty($manager2->get($field, $language));
	}

	/**
	 * @depends testGet
	 */
	public function testSet()
	{
		$I = $this->tester;

		$record   = 1;
		$field    = 'name';
		$language = 'en';

		$I->haveInDatabase('basic', ['id' => $record]);

		$model = \Mocks\Basic::findFirst($record);
		$manager = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($model, ['id']);

		$expected = 'fooo';
		$manager->set($field, $language, $expected);
		$this->assertEquals($expected, $manager->get($field, $language));

		$manager->set($field, $language, 'baaar');
		$this->assertEquals('baaar', $manager->get($field, $language));

		$empty = new \Mocks\Basic();
		$manager2 = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($empty, ['id']);
		$expected2 = 'bar';
		$manager2->set($field, $language, $expected2);
		$this->assertEquals($expected2, $manager2->get($field, $language));
	}

	/**
	 * @depends testSet
	 */
	public function testPersist()
	{
		$I = $this->tester;

		$record   = 1;
		$field    = 'name';
		$language = 'en';

		$I->haveInDatabase('basic', ['id' => $record]);
		$I->haveInCollection('translation', [
			'db'       => 'db',
			'table'    => \Mocks\Basic::SRC_TABLE,
			'row'      => "$record",
			'language' => [
				$language => [
					$field => 'bar'
				]
			]
		]);

		$model = \Mocks\Basic::findFirst(1);
		$manager = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($model, ['id']);

		$expected = 'fooo';
		$manager->set($field, $language, $expected);
		$manager->persist();

		$I->seeInCollection('translation', [
			'db'       => 'db',
			'table'    => \Mocks\Basic::SRC_TABLE,
			'row'      => "$record",
			'language' => [
				$language => [
					$field => $expected
				]
			]
		]);

		$manager->set($field, $language, 'baaar');
		$manager->set('description', 'es', 'foooo');
		$manager->set('name', 'es', 'fooobar');
		$manager->persist(['en' => ['name'], 'es' => ['description', 'long_description']]);

		$I->seeInCollection('translation', [
			'db'       => 'db',
			'table'    => \Mocks\Basic::SRC_TABLE,
			'row'      => "$record",
			'language' => [
				'en' => [
					$field => 'baaar'
				],
				'es' => [
					'description' => 'foooo',
					'long_description' => ''
				]
			]
		]);

		$empty = new \Mocks\Basic();
		$manager2 = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($empty, ['id']);

		$manager2->set('name', 'en', 'foofoo');
		$this->assertFalse($manager2->persist());
	}

	public function testRemove()
	{
		$I = $this->tester;

		$record   = 1;
		$field    = 'name';
		$language = 'en';

		$I->haveInDatabase('basic', ['id' => $record]);
		$I->haveInCollection('translation', [
			'db'       => 'db',
			'table'    => \Mocks\Basic::SRC_TABLE,
			'row'      => "$record",
			'language' => [
				$language => [
					$field => 'bar'
				]
			]
		]);

		$model = \Mocks\Basic::findFirst(1);
		$manager = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($model, ['id']);

		$manager->remove();

		$I->dontSeeInCollection('translation', [
			'db'       => 'db',
			'table'    => \Mocks\Basic::SRC_TABLE,
			'row'      => "$record",
			'language' => [
				$language => [
					$field => 'bar'
				]
			]
		]);

		$empty = new \Mocks\Basic();
		$manager2 = \Ovide\Lib\Translate\Adapter\Collection\Manager::retrieve($empty, ['id']);

		$this->assertFalse($manager2->remove());
	}
}
