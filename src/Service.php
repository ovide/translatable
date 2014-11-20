<?php namespace Ovide\Lib\Translate;

/**
 * Injectable service for translatable models.
 *
 * You can attach an adapter for each connection service ('db' is the default)
 */
class Service implements \Phalcon\DI\InjectionAwareInterface
{
	/**
	 * DependencyInjector
	 *
	 * @var \Phalcon\DiInterface
	 */
	protected $_di;

	/**
	 * Association of translatable models with its translation adapter
	 *
	 * @var array
	 */
	protected $_connections = [];

	/**
	 * Association of connections indexed by their binded model
	 *
	 * @var array $modelName => $connectionService
	 */
	protected $_models = [];

	/**
	 * Binds a model to a connection service
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
	 * @return TranslationInterface
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
	 * {@inheritdoc}
	 *
	 * @return \Phalcon\DiInterface
	 */
	public function getDI()
	{
		return $this->_di;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @param \Phalcon\DiInterface
	 */
	public function setDI($dependencyInjector)
	{
		$this->_di = $dependencyInjector;
	}
}
