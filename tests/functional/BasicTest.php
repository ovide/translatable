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
				'dbname'   => 'translatabl2'
			]);
		});

		$mockBackend = $this->getMock(Ovide\Lib\Translate\Adapter\AbstractBackend::class, ['getSource'])
				->expects($this->any())
				->method('getSource')
				->willReturn('translation');

		$this->di->setShared('translator', function() use ($mockBackend) {
			$backend = get_class($mockBackend);
			$service = new \Ovide\Lib\Translate\Service();
			$service->attachAdapter('db', Ovide\Lib\Translate\Model::class, ['backendModel' => $backend]);
			$service->attachAdapter('db2', Ovide\Lib\Translate\Model::class);
			return $service;
		});
    }
}