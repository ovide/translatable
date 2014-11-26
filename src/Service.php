<?php namespace Ovide\Lib\Translate;

/**
 * Service for translatable models.
 *
 * You can attach an adapter for each connection service ('db' is the default)
 */
class Service
{
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
     * Check if given model is already binded
     *
     * @param  string $modelName
     * @return bool
     */
    public function isModelBinded($modelName)
    {
        return isset($this->_models[$modelName]);
    }

    /**
     * Attaches an adapter to a DB connection service
     *
     * @param string $con              The name of the connecion (ex. 'db')
     * @param string $adapterClassName
     */
    public function attachAdapter($con, $adapterClassName, array $options = null)
    {
        $this->_connections[$con] = [
            'manager' => $adapterClassName,
            'options' => $options,
        ];
    }

    /**
     * Gets a translation adapter instance for the given model name
     *
     * @param  string $modelName
     * @return array
     *                          'manager' => string The Translation adapter class name
     *                          'options' => array  Array of options
     */
    public function getAdapterFor($modelName)
    {
        if (!isset($this->_models[$modelName])) {
            $this->_models[$modelName] = 'db';
        }

        return $this->_connections[$this->_models[$modelName]];
    }
}
