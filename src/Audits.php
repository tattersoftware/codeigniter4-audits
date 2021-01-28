<?php namespace Tatter\Audits;

use Tatter\Audits\Models\AuditModel;
use Tatter\Audits\Config\Audits as AuditsConfig;

/*** CLASS ***/
class Audits
{
	/**
	 * Our configuration instance.
	 *
	 * @var AuditsConfig
	 */
	protected $config;
	
	/**
	 * Audit rows waiting to add to the database.
	 *
	 * @var array
	 */
	protected $queue = [];

	/**
	 * Store the configuration
	 *
	 * @param AuditsConfig $config  The Audits configuration to use
	 */
	public function __construct(AuditsConfig $config)
	{		
		$this->config = $config;
	}

	/**
	 * Checks the session for a logged in user based on config
	 *
	 * @return int  The current user ID, 0 for "not logged in", -1 for CLI
	 */
	public function sessionUserId(): int
	{
		if (is_cli())
		{
			return -1;
		}

		return session($this->config->sessionUserId) ?? 0;
	}

	/**
	 * Return the current queue (mostly for testing)
	 *
	 * @return array
	 */
	public function getQueue(): array
	{
		return $this->queue;
	}

	/**
	 * Add an audit row to the queue
	 *
	 * @param array|null $audit The row to cache for insert
	 */
	public function add(array $audit = null)
	{
		if (empty($audit))
		{
			return false;
		}

		// Add common data
		$audit['user_id']    = $this->sessionUserId();
		$audit['created_at'] = date('Y-m-d H:i:s');

		$this->queue[] = $audit;
	}

	/**
	 * Batch insert all audits from the queue
	 *
	 * @return $this
	 */
	public function save(): self
	{
		if (! empty($this->queue))
		{
			$audits = new AuditModel();
			$audits->insertBatch($this->queue);
		}

		return $this;
	}
}
