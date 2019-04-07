<?php namespace Tatter\Audits\Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Database\ConnectionInterface;

class Services extends BaseService
{
    public static function audits(BaseConfig $config = null, bool $getShared = true)
    {
		if ($getShared):
			return static::getSharedInstance('audits', $config);
		endif;

		// prioritizes user config in app/Config if found
		if (empty($config)):
			if (class_exists('\Config\Audits')):
				$config = new \Config\Audits();
			else:
				$config = new \Tatter\Audits\Config\Audits();
			endif;
		endif;

		return new \Tatter\Audits\Audits($config);
	}
}
