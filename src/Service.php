<?php namespace Ovide\Lib\Translate;


class Service implements \Phalcon\DI\InjectionAwareInterface
{
	/**
	 * @var \Phalcon\DiInterface
	 */
	protected $_di;

	/**
	 * Association of translatable models with its translation adapter
	 *
	 * @var array
	 */
	protected $_connections = [];

	protected $_models = [];

	/**
	 *
	 * @param string $con
	 * @param string $modelName
	 */
	public function bindModelConnection($con, $modelName)
	{
		$this->_models[$modelName] = $con;
	}

	/**
	 * Attaches an adapter to a DB connection service
	 *
	 * @param string $con The name of the connecion (ex. 'db')
	 * @param string $adapterClassName
	 */
	public function attachAdapter($con, $adapterClassName)
	{
		$this->_connections[$con] = $adapterClassName;
	}

	/**
	 * Gets a translation adapter instance for the given model name
	 *
	 * @param string $modelName
	 * @return Translation
	 */
	public function getAdapterFor($modelName)
	{
		if (!isset($this->_models[$modelName])) {
			$this->_models[$modelName] = 'db';
		}

		$model = $this->_connections[$this->_models[$modelName]];
		return new $model();
	}

	/**
	 * @return \Phalcon\DiInterface
	 */
	public function getDI()
	{
		return $this->_di;
	}

	/**
	 * @param \Phalcon\DiInterface
	 */
	public function setDI($dependencyInjector)
	{
		$this->_di = $dependencyInjector;
	}

}
