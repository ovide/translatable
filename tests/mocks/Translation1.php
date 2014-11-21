<?php namespace Mocks;

class Translation1 extends \Ovide\Lib\Translate\Adapter\Model\AbstractBackend
{
	public function getSource() {
		return 'translation';
	}
}
