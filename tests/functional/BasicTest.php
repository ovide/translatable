<?php


class BasicTest extends \Codeception\TestCase\Test
{
   /**
    * @var \FunctionalTester
    */
    protected $tester;

	protected $di;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testConfigure()
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
		$this->di->setShared('db2', function() {
			return new \Phalcon\Db\Adapter\Pdo\Mysql([
				'host'     => 'localhost',
				'username' => 'translatable',
				'password' => 'translatable',
				'dbname'   => 'translatable2'
			]);
		});
		$this->di->setShared('mongo', function() {
			$mongo = new \MongoClient('mongodb://127.0.0.1:27017');
			return $mongo->selectDB("translatable");
		});

		$this->di->setShared('translator', function() {

			$service = new \Ovide\Lib\Translate\Service();
			$service->attachAdapter('db', Ovide\Lib\Translate\Adapter\Model\Manager::class, [
				'backendModel' => \Mocks\Translation1::class
			]);
			$service->attachAdapter('db', Ovide\Lib\Translate\Adapter\Model\Manager::class, [
				'backendModel' => \Mocks\Translation2::class
			]);
			$service->attachAdapter('mongoTranslator', \Ovide\Lib\Translate\Adapter\Collection\Manager::class);
			$service->bindModelConnection('mongoTraslator', \Mocks\Table13::class);
			return $service;
		});
    }

	public function testSetFirstTranslations()
	{
		$t11r1 = new Mocks\Table11();
		$t11r1->create(['id' => 1, 'name' => 'table11 record1 name']);
	}
}