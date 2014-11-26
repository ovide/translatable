<?php namespace Ovide\Lib\Translate\Adapter\Collection;

/**
 * Backend collection for the Manager
 *
 * The database table must have these rows:
 *
 * @see Manager
 */
class Translation extends \Phalcon\Mvc\Collection
{
    public $db;
    public $table;
    public $row;
    public $language;
}
