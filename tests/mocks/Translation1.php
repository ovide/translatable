<?php namespace mocks;

class Translation1 extends \Ovide\Lib\Translate\Adapter\Model\AbstractBackend
{
    public function initialize()
    {
        $this->setSource('translation');
        $this->setConnectionService('db');
    }
}
