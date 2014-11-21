<?php namespace Mocks;

/**
 * @property string $name
 * @property string $description
 * @property Table11 t1
 * @property Table12 t2
 */
class Table13 extends \Ovide\Lib\Translate\Model
{
	const SRC_TABLE = 'table3';

	public $t1_id;
	public $t2_id;

	protected $_translatable = ['name', 'description'];

	public function initialize()
	{
		$this->setSource(static::SRC_TABLE);
		$this->hasManyToMany('id', Table13::class, 't2_id', 't1_id', Table11::class, 'id', ['alias' => 't1']);
		$this->hasMany('id', Table13::class, 't2_id', ['alias' => 't3']);
	}
}