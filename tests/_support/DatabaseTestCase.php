<?php namespace Tests\Support;

use CodeIgniter\Test\CIDatabaseTestCase;

class DatabaseTestCase extends CIDatabaseTestCase
{
	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;

	/**
	 * Our configuration
	 *
	 * @var Tatter\Audits\Config\Audits
	 */
	protected $config;

	public function setUp(): void
	{
		parent::setUp();

		$config         = new \Tatter\Audits\Config\Audits();
		$config->silent = false;
		$this->config   = $config;
	}
}
