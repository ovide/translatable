<?php namespace Ovide\Lib\Translate\Adapter\Model;

/**
 * Model adapter manager for Translation Interface
 *
 * A 'backendModel' option must be given when the adapter is attached
 *
 * ```php
 * $translator->attachAdapter('db', Ovide\Lib\Translate\Model::class, [
 *         'backendModel' => MyTranslationsModel::class
 * ]);
 * ```
 *
 * Needs a \Phalcon\Mvc\Model binded to a SQL table with columns:
 *
 * - table    VARCHAR
 * - row      VARCHAR
 * - field    VARCHAR
 * - language VARCHAR
 * - text     TEXT
 *
 * @see AbstractBackend
 * @internal Uses a \Phalcon\Mvc\Model instance for each translated text (language + field)
 */
class Manager implements \Ovide\Lib\Translate\TranslationInterface
{
	/**
	 * Dictoionary of translated fields
	 *
	 * @var array [string $language => [ string $field => \Phalcon\Mvc\Model $translation]]
	 */
	protected $_translations = [];

	/**
	 * Field keys that identifies the $_src model
	 *
	 * @var array
	 */
	protected $_pk;

	/**
	 * The source model
	 *
	 * @var \Ovide\Lib\Translate\Model
	 */
	protected $_src;

	/**
	 * The key used to retrieve the translation record.
	 *
	 * @var string
	 */
	protected $_key = null;

	/**
	 * The Model used to manage the translations
	 *
	 * @var string
	 */
	protected $_backend;

	/**
	 * The separator used to generate the $_key
	 */
	const KEY_GLUE = '@';

	/**
	 * {@inheritdoc}
	 */
	protected function __construct(\Ovide\Lib\Translate\Model $src, $pk, array $options)
	{
		$this->_src     = $src;
		$this->_pk      = $pk;
		$this->_backend = $options['backendModel'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($field, $language)
	{
		if (!isset($this->_translations[$language])) {
			if ($this->_src->getDirtyState() === \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT) {
				return '';
			}

			$this->_translations[$language] = [];
		}

		if (!isset($this->_translations[$language][$field])) {
			if ($this->_key === null) {
				$this->generateKey();
			}

			$this->fetchRecord($field, $language);
		}

		return $this->_translations[$language][$field]->text;
	}

	/**
	 * Generates a unique key that identifies the translations record for the current model
	 */
	protected function generateKey()
	{
		$this->_key = implode(static::KEY_GLUE, $this->_src->toArray($this->_pk));
	}

	/**
	 * Gets the translation record from DB
	 *
	 * @param string $field
	 * @param string $language
	 */
	protected function fetchRecord($field, $language)
	{
		$data = [
			'table' => $this->_src->getSource(),
			'row'   => $this->_key,
			'field' => $field,
			'lang'  => $language
		];

		$className = $this->_backend;
		$this->_translations[$language][$field] = $className::findFirst([
			'table = :table: AND row = :row: AND field = :field: AND lang = :lang:',
			'bind' => $data
		]);

		if (!$this->_translations[$language][$field]) {
			$new = new $className($data);
			$new->text = '';
			$this->_translations[$language][$field] = $new;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function persist(array $records = null)
	{
		if ($this->_src->getDirtyState() === \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT) {
			return false;
		}

		if ($records === null) {
			array_walk_recursive($this->_translations, function($model) {
				$model->save();
			});
		} else {
			foreach ($records as $language => $fields) {
				foreach ($fields as $field) {
					$this->_translations[$language][$field]->save();
				}
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove()
	{
		if ($this->_src->getDirtyState() === \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT) {
			return false;
		}

		if ($this->_key === null) {
			$this->generateKey();
		}

		$className = $this->_backend;
		$result = $className::find(['table = :table: AND row = :row:', 'bind' => [
			'table' => $this->_src->getSource(),
			'row'   => $this->_key
		]]);

		foreach ($result as $model) {
			$model->delete();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function set($field, $language, $value)
	{
		if (!isset($this->_translations[$language])) {
			$this->_translations[$language] = [];
		}

		if ($this->_translations[$language][$field] instanceof \Phalcon\Mvc\Model) {
			$this->_translations[$language][$field]->text = $value;
		} else {
			if ($this->_src->getDirtyState() !== \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT && $this->_key === null) {
				$this->generateKey();
			}

			$className = $this->_backend;
			$this->_translations[$language][$field] = new $className([
				'table'    => $this->_src->getSource(),
				'row'      => $this->_key,
				'field'    => $field,
				'language' => $language,
				'text'     => $value
			]);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public static function retrieve(\Ovide\Lib\Translate\Model $model, $pk, array $options=null)
	{
		if ($options === null || !isset($options['backendModel'])) {
			throw new \LogicException("backendModel must be given");
		}
		return new static($model, $pk, $options);
	}
}
