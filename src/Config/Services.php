<?php namespace Tatter\Audits\Config;

use Config\Services as BaseServices;
use Tatter\Audits\Audits;
use Tatter\Audits\Config\Audits as AuditsConfig;

class Services extends BaseServices
{
	/**
	 * @param AuditsConfig|null $config
	 * @param bool $getShared
	 *
	 * @return Audits
	 */
    public static function audits(AuditsConfig $config = null, bool $getShared = true): Audits
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

		return new Audits($config);
	}
}
