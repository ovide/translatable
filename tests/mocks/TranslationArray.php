<?php namespace Mocks;


class TranslationArray implements \Ovide\Lib\Translate\TranslationInterface
{
	protected $_translations =
	[
		1 => [
			'en' => [
				'name' => 'The translated name',
				'description' => 'The translated description'
			]
		]
	];

	protected $_tmpTranslations = [];

	protected $_id;

	private static $__counter = [];

	public function get($field, $language)
	{
		static::increment(__FUNCTION__);
		if ($this->_id && isset($this->_translations[$this->_id][$language][$field])) {
			return $this->_translations[$this->_id][$language][$field];
		}

		if (isset($this->_tmpTranslations[$language][$field])) {
			return $this->_tmpTranslations[$language][$field];
		}

		return '';
	}

	public function persist(array $records = null)
	{
		static::increment(__FUNCTION__);
		return null;
	}

	public function remove()
	{
		static::increment(__FUNCTION__);
		return null;
	}

	public function set($field, $language, $value)
	{
		static::increment(__FUNCTION__);
		$this->_tmpTranslations[$language][$field] = $value;
	}

	public static function retrieve(\Ovide\Lib\Translate\Model $model, $pk)
	{
		static::increment(__FUNCTION__);

		$instance = new static();
		$instance->_id = $model->{$pk[0]};

		return $instance;
	}

	private static function increment($function)
	{
		if (!isset(static::$__counter[$function])) {
			static::$__counter[$function] = 1;
		} else {
			static::$__counter[$function]++;
		}
	}

	public static function resetCounter()
	{
		return static::getCounter();
		static::$__counter = [];
	}

	public static function getCounter()
	{
		return static::$__counter;
	}
}
