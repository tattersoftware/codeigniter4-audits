<?php namespace Tatter\Audits\Config;

use CodeIgniter\Config\BaseConfig;

class Audits extends BaseConfig
{
	// key in $_SESSION that contains the integer ID of a logged in user
	public $sessionUserId = "userId";

	// whether to continue instead of throwing exceptions
	public $silent = true;
}
