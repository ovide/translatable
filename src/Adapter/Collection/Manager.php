<?php namespace Ovide\Lib\Translate\Adapter\Collection;

/**
 * Collection adapter manager for Translation Interface
 *
 * A 'backendModel' option must be given when the adapter is attached
 *
 * ```php
 * $translator->attachAdapter('db', Ovide\Lib\Translate\Collection::class, [
 *         'backendCollection' => MyTranslationsCollection::class
 * ]);
 * ```
 *
 * Needs a \Phalcon\Mvc\Collection binded to a No-SQL (mongo) table with columns:
 *
 * @internal Uses a \Phalcon\Mvc\Collection instance for each translated text (language + field)
 */
class Manager implements \Ovide\Lib\Translate\TranslationInterface
{
	/**
	 * @var Translation
	 */
	protected $_translations;

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
	 * A copy of the current record. Used to undo inmemory changes
	 *
	 * @var Translation
	 */
	protected $_cur;

	/**
	 * The separator used to generate the $_key
	 */
	const KEY_GLUE = '@';

	/**
	 * {@inheritdoc}
	 */
	protected function __construct(\Ovide\Lib\Translate\Model $src, $pk)
	{
		$this->_src     = $src;
		$this->_pk      = $pk;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($field, $language)
	{
		if (!isset($this->_translations->language)) {
			if ($this->_src->getDirtyState() === \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT) {
				return '';
			}
		}

		if (!isset($this->_translations->language[$language][$field])) {
			if ($this->_key === null) {
				$this->generateKey();
			}

			$this->fetchRecord();
		}

		if (!isset($this->_translations->language[$language][$field])) {

			if (!isset($this->_translations->language[$language])) {
				$this->_translations->language[$language] = [];
			}

			$this->_translations->language[$language][$field] = '';
		}

		return $this->_translations->language[$language][$field];
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
	protected function fetchRecord()
	{
		$data = [
			'db'    => $this->_src->getReadConnectionService(),
			'table' => $this->_src->getSource(),
			'row'   => $this->_key
		];

		$this->_translations = Translation::findFirst([$data]);

		if (!$this->_translations) {
			$this->_translations           = new Translation();
			$this->_translations->db       = $data['db'];
			$this->_translations->table    = $data['table'];
			$this->_translations->row      = $this->_key;
			$this->_translations->language = [];
		}

		$this->_cur = clone $this->_translations;
	}

	/**
	 * {@inheritdoc}
	 */
	public function persist(array $records = null)
	{
		if ($this->_src->getDirtyState() === \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT) {
			return false;
		}

		if ($this->_translations && !$this->_translations->row) {
			$this->generateKey();
			$this->_translations->row = $this->_key;
		}

		if ($records === null) {
			$this->_cur = clone $this->_translations;
		} else if(count($records)) {
			$this->_mergeRecords($records);
		} else {
			return true;
		}

		$this->_cur->save();
	}

	private function _mergeRecords(array $records)
	{
		$this->_cur->row = $this->_translations->row;
		foreach ($records as $language => $fields) {
			foreach ($fields as $field) {
				if (!isset($this->_cur->language[$language])) {
					$this->_cur->language[$language] = [];
				}

				$this->_cur->language[$language][$field] = isset($this->_translations->language[$language][$field]) ?
					$this->_translations->language[$language][$field] :	'';
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
		if (!isset($this->_translations)) {
			$this->fetchRecord();
		}

		return $this->_translations->delete();
	}

	/**
	 * {@inheritdoc}
	 */
	public function set($field, $language, $value)
	{
		if ($this->_src->getDirtyState() !== \Phalcon\Mvc\Model::DIRTY_STATE_TRANSIENT && $this->_key === null) {
			$this->generateKey();
		}

		if (!$this->_translations) {
			$this->fetchRecord();
		}

		if (!isset($this->_translations->language[$language][$field])) {
			if (!isset($this->_translations->language[$language])) {
				$this->_translations->language[$language] = [];
			}
		}

		$this->_translations->language[$language][$field] = $value;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function retrieve(\Ovide\Lib\Translate\Model $model, $pk, array $options=null)
	{
		return new static($model, $pk);
	}
}
