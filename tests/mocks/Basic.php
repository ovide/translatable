<?php namespace mocks;

/**
 * @property string $name
 * @property string $description
 */
class Basic extends \Ovide\Lib\Translate\Model
{
    const SRC_TABLE = 'basic';

    public $id;
    public $value;

    protected $_translatable = ['name', 'description'];

    public function initialize()
    {
        $this->setSource(static::SRC_TABLE);
    }
}
