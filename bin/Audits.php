<?php namespace Config;

/***
*
* This file contains example values to alter default library behavior.
* Recommended usage:
*	1. Copy the file to app/Config/Audits.php
*	2. Change any values
*	3. Remove any lines to fallback to defaults
*
***/

use CodeIgniter\Config\BaseConfig;

class Audits extends \Tatter\Audits\Config\Audits
{
	// key in $_SESSION that contains the integer ID of a logged in user
	public $sessionUserId = "userId";

	// whether to continue instead of throwing exceptions
	public $silent = true;
}
