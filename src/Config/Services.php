<?php namespace Tatter\Audits\Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function audits(BaseConfig $config = null, bool $getShared = true)
    {
		if ($getShared)
		{
			return static::getSharedInstance('audits', $config);
		}

		// If no config was injected then load one
		if (empty($config))
		{
			$config = config('Audits');
		}

		return new \Tatter\Audits\Audits($config);
	}
}
