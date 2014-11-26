<?php


class BasicTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \FunctionalTester
	 */
    protected $tester;

	/**
	 * @var Phalcon\DI
	 */
	protected $di;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testConfigure()
    {
		$this->di = Phalcon\DI::reset();
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
			$service->attachAdapter('db2', Ovide\Lib\Translate\Adapter\Model\Manager::class, [
				'backendModel' => \Mocks\Translation2::class
			]);
			$service->attachAdapter('mongoTranslator', \Ovide\Lib\Translate\Adapter\Collection\Manager::class);
			$service->bindModelConnection('mongoTranslator', \Mocks\Table13::class);
			$service->bindModelConnection('mongoTranslator', \Mocks\Table22::class);

			return $service;
		});
    }

	public function testSetFirstTranslations()
	{
		$t11r1 = new Mocks\Table11();
		$t11r1->create(['id' => 1, 'name' => 'table11 record1 name']);
		$this->assertEquals('table11 record1 name', $t11r1->name);
		$t11r1->description = 'table11 record1 description';
		$t11r1->save();
		$this->assertEquals('table11 record1 description', $t11r1->description);
		$t11r2 = new Mocks\Table11();
		$t11r2->name = 'table11 record2 name';
		$t11r2->id   = 2;

		$t12r1 = new Mocks\Table12();
		$t12r1->id          = 1;
		$t12r1->name        = 'table12 record1 name';
		$t12r1->description = 'table12 record1 description';
		$t12r1->save();
		$t11r2->save();

		$t13r1 = new \Mocks\Table13();
		$t13r1->t1_id       = $t11r1->id;
		$t13r1->t2_id       = $t12r1->id;
		$t13r1->save();
		$t13r1->name        = '1-1 name';
		$t13r1->description = '1-1 description';

		$t12r1->save();
		$t13r1->save();

		$t21r1 = new \Mocks\Table21();
		$t21r1->id    = 1;
		$t21r1->value = 'foo';
		$t21r1->name  = 'the name';
		$t21r1->save();
		$t21r1->description = 'the description';

		$t22r1 = new Mocks\Table22();
		$t22r1->t1_id = $t21r1->id;
		$t22r1->description = 'fooo';
		$t22r1->name = 'name';
		$t22r1->save();
	}

	public function testPersistence()
	{
		$t11r1 = Mocks\Table11::findFirst(1);
		$t11r2 = Mocks\Table11::findFirst(2);
		$this->assertEquals('table11 record1 name', $t11r1->name);
		$this->assertEquals('table11 record1 description', $t11r1->description);
		$this->assertEquals('table11 record2 name', $t11r2->name);
		$this->assertEmpty($t11r2->description);
		$this->assertEquals('1-1 name', $t11r1->t3[0]->name);
		$this->assertEquals('1-1 description', $t11r1->t3[0]->description);
		$t22r1 = Mocks\Table22::findFirst();
		$this->assertEquals('name', $t22r1->name);
		$this->assertEquals('fooo', $t22r1->description);
		$this->assertEmpty($t22r1->t1->description);
		$this->assertEquals('the name', $t22r1->t1->name);
		$this->assertEquals('foo', $t22r1->t1->value);
	}

	public function testChangeLanguage()
	{
		/* @var $t11r1 \Ovide\Lib\Translate\Model */
		/* @var $t11r2 \Ovide\Lib\Translate\Model */
		/* @var $t22r1 \Ovide\Lib\Translate\Model */
		/* @var $t13r1 \Ovide\Lib\Translate\Model */
		$t11r1 = Mocks\Table11::findFirst(1);
		$t11r2 = Mocks\Table11::findFirst(2);

		$t13r1 = $t11r1->t3[0];
		$t11r1->setCurrentLang('es');
		$t11r1->name = 'Nombre de t11r1';
		$t11r1->description = 'descripción de t11r1';
		$t11r1->save();

		$t11r2->name = 't11r2 en name';
		$t11r2->setCurrentLang('es');
		$t11r2->save();
		$t11r2->description = 'no se guardará';
		$t13r1->setTranslation('name', 'Nombre para t13r1', 'es');
		$t13r1->setTranslation('name', 'Nom per t13r1', 'ca');
		$t13r1->setTranslation('description', 'La descripció', 'ca');
		$t13r1->setTranslation('description', 'The description', 'en');
		$t13r1->save();

		$curLang = 'ca';
		\Ovide\Lib\Translate\Model::setLanguageResolver(function() use($curLang) {
			return $curLang;
		});

		$t22r1 = Mocks\Table22::findFirst();
		$this->assertEquals($curLang, $t22r1->getCurrentLang());
		$t22r1->name = 'El nom';
		$t22r1->description = 'La descripció';
		$t22r1->t1->name = 'Un altre nom';
		$t22r1->t1->description = 'Una altra descripció';
		$t22r1->save();
	}

	public function testGetDifferentLanguages()
	{
		/* @var $t11r1 \Ovide\Lib\Translate\Model */
		/* @var $t11r2 \Ovide\Lib\Translate\Model */
		/* @var $t22r1 \Ovide\Lib\Translate\Model */
		/* @var $t13r1 \Ovide\Lib\Translate\Model */
		$t11r1 = Mocks\Table11::findFirst(1);
		$t11r2 = Mocks\Table11::findFirst(2);
		$t22r1 = Mocks\Table22::findFirst();
		$t13r1 = $t11r1->t3[0];

		$t11r1->setCurrentLang('en');
		$this->assertEquals('table11 record1 description', $t11r1->description);
		$this->assertEquals('table11 record1 name', $t11r1->name);
		$t11r1->setCurrentLang('es');
		$this->assertEquals('descripción de t11r1', $t11r1->description);
		$this->assertEquals('Nombre de t11r1', $t11r1->name);

		$this->assertEquals('t11r2 en name', $t11r2->getTranslation('name', 'en'));

		$this->assertEquals('table12 record1 description', $t11r1->t2[0]->getTranslation('description', 'en'));
		$this->assertEquals('table12 record1 name', $t11r1->t2[0]->getTranslation('name', 'en'));

		$this->assertEquals('Nom per t13r1', $t13r1->name);
		$this->assertEquals('La descripció', $t13r1->description);
		$this->assertEquals('Nombre para t13r1', $t13r1->getTranslation('name', 'es'));
		$this->assertEmpty($t13r1->getTranslation('description', 'es'));
		$this->assertEquals('1-1 name', $t13r1->getTranslation('name', 'en'));
		$this->assertEquals('The description', $t13r1->getTranslation('description', 'en'));

		$this->assertEquals('El nom', $t22r1->name);
		$this->assertEquals('La descripció', $t22r1->description);
		$this->assertEquals('name', $t22r1->getTranslation('name', 'en'));
		$this->assertEquals('fooo', $t22r1->getTranslation('description', 'en'));
		$this->assertEquals('Un altre nom', $t22r1->t1->name);
		$this->assertEquals('Una altra descripció', $t22r1->t1->description);
		$this->assertEquals('the name', $t22r1->t1->getTranslation('name', 'en'));
		$this->assertEmpty($t22r1->t1->getTranslation('description', 'es'));
		$this->assertEmpty($t22r1->getTranslation('name', 'es'));
	}
}
