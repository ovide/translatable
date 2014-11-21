<?php namespace Mocks;

/**
 * @property string $name
 * @property string $description
 * @property Table22[] $t2
 */
class Table21 extends \Ovide\Lib\Translate\Model
{
	const SRC_TABLE = 'table1';

	public $id;
	public $value;

	protected $_translatable = ['name', 'description'];

	public function initialize()
	{
		$this->setSource(static::SRC_TABLE);
		$this->setConnectionService('db2');
		$this->hasMany('id', Table22::class, 't1_id', ['alias' => 't2']);
	}
}
