<?php namespace mocks;

class Translation2 extends \Ovide\Lib\Translate\Adapter\Model\AbstractBackend
{
    public function initialize()
    {
        $this->setSource('translation');
        $this->setConnectionService('db2');
    }
}
