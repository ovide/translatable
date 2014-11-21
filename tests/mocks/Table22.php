<?php namespace Mocks;

/**
 * @property string $description
 * @property Table21 $t1
 */
class Table22 extends \Ovide\Lib\Translate\Model
{
	const SRC_TABLE = 'table2';

	public $id;
	public $t1_id;

	protected $_translatable = ['name', 'description'];

	public function initialize()
	{
		$this->setSource(static::SRC_TABLE);
		$this->setConnectionService('db2');
		$this->belongsTo('t1_id', Table21::class, 'id', ['alias' => 't1']);
	}
}
