<?php namespace Ovide\Lib\Translate\Adapter\Model;

/**
 * Backend model for the Manager
 *
 * The database table must have these rows:
 *
 * - table    VARCHAR
 * - row      VARCHAR
 * - field    VARCHAR
 * - language VARCHAR
 * - text     TEXT
 *
 * @see Manager
 */
abstract class AbstractBackend extends \Phalcon\Mvc\Model
{
	public $table;
	public $row;
	public $field;
	public $lang;
	public $text;
}
