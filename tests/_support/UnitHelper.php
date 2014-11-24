<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class UnitHelper extends \Codeception\Module
{
    /**
     * @param string $table
     * @param array $filter
     */
	public function dropFromDB($table, array $filter=null)
	{
		$driver = $this->getCon();

		$query = "DELETE FROM `$table`";
		if ($filter !== null) {
			$where  = [];
			foreach ($filter as $key => $value) {
				$value   = mysql_escape_string($value);
				$where[] = "`$key` = '$value'";
			}
			$query .= 'WHERE '.implode(' AND ', $where);
		}

		$driver->exec($query);
	}

	/**
	 * @return \PDO
	 */
	private function getCon()
	{
        $config = \Codeception\Configuration::config();
        $dbConf = $config['modules']['config']['Db'];
        return \Codeception\Lib\Driver\Db::create($dbConf['dsn'], $dbConf['user'], $dbConf['password'])->getDbh();
	}
}