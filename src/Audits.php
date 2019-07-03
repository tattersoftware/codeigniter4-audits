<?php namespace Tatter\Audits;

/***
* Name: Audits
* Author: Matthew Gatner
* Contact: mgatner@tattersoftware.com
* Created: 2019-04-05
*
* Description:  Lightweight object logging for CodeIgniter 4
*
* Requirements:
* 	>= PHP 7.1
* 	>= CodeIgniter 4.0
*	Preconfigured, autoloaded Database
*	`audits` table (run migrations)
*
* Configuration:
* 	Use Config/Audits.php to override default behavior
* 	Run migrations to update database tables:
* 		> php spark migrate:latest -all
*
* @package CodeIgniter4-Audits
* @author Matthew Gatner
* @link https://github.com/tattersoftware/codeigniter4-audits
*
***/

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\Services;
use Tatter\Audits\Models\AuditModel;
//use Tatter\Audits\Exceptions\AuditsException;

/*** CLASS ***/
class Audits
{
	/**
	 * Our configuration instance.
	 *
	 * @var \Tatter\Audits\Config\Audits
	 */
	protected $config;

	/**
	 * The active user session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;
	
	// array of audit rows waiting to add to the database
	protected $queue = [ ];
	
	// initiate library, check for existing session
	public function __construct(BaseConfig $config)
	{		
		// save configuration
		$this->config = $config;

		// initiate the Session library
		$this->session = Services::session();
	}
	
	// checks for a logged in user based on config
	// returns user ID, 0 for "not logged in", -1 for CLI
	public function sessionUserId(): int
	{
		if (is_cli())
			return -1;
		return $this->session->get($this->config->sessionUserId) ?? 0;
	}
	
	// add an audit row to the queue
	public function add($audit)
	{
		if (empty($audit))
			return false;
		
		// add common data
		$audit['user_id'] = $this->sessionUserId();
		$audit['created_at'] = date('Y-m-d H:i:s');
		$this->queue[] = $audit;
	}
	
	// batch insert all audits from the queue
	public function save()
	{
		if (empty($this->queue))
			return;

		$audits = new AuditModel();
		$audits->insertBatch($this->queue);
	}
}
