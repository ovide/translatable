<?php namespace mocks;

/**
 * @property string $name
 * @property string $description
 * @property Table12[] t2
 * @property Table13[] t3
 */
class Table11 extends \Ovide\Lib\Translate\Model
{
    const SRC_TABLE = 'table1';

    public $id;

    protected $_translatable = ['name', 'description'];

    public function initialize()
    {
        $this->setSource(static::SRC_TABLE);
        $this->hasManyToMany('id', Table13::class, 't1_id', 't2_id', Table12::class, 'id', ['alias' => 't2']);
        $this->hasMany('id', Table13::class, 't1_id', ['alias' => 't3']);
    }
}
