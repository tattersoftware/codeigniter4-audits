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

class Audits extends \Tatter\Audits\Config\Audits
{
	// Session key in that contains the integer ID of a logged in user
	public $sessionUserId = "logged_in";

	// Whether to continue instead of throwing exceptions
	public $silent = true;
}
