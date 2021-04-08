<?php namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Config\Services;
use Tatter\Audits\Audits;
use Tatter\Audits\Config\Audits as AuditsConfig;
use Tests\Support\Models\WidgetModel;

class DatabaseTestCase extends CIUnitTestCase
{
	use DatabaseTestTrait;

	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;

	/**
	 * Our configuration
	 *
	 * @var AuditsConfig
	 */
	protected $config;

	/**
	 * Instance of the test model
	 *
	 * @var WidgetModel
	 */
	protected $model;

	/**
	 * Instance of the fabricator primed with our model
	 *
	 * @var Fabricator
	 */
	protected $fabricator;

	public function setUp(): void
	{
		parent::setUp();

		$config         = new AuditsConfig();
		$config->silent = false;
		$this->config   = $config;
		
		// Reset the service
		$audits = new Audits($config);
		Services::injectMock('audits', $audits);

		// Prep model components
		$this->model      = new WidgetModel();
		$this->fabricator = new Fabricator($this->model);
	}

	/**
	 * Asserts that an audit with the given properties is in the queue
	 *
	 * @param array $values  Array of values to confirm
	 */
	public function seeAudit(array $values)
	{
		$queue = service('audits')->getQueue();
		$found = false;

		// Check each audit in the queue for a match
		foreach ($queue as $audit)
		{
			// Check each value against the audit
			foreach ($values as $key => $value)
			{
				if ($audit[$key] != $value)
				{
					break 2;
				}
			}

			$found = true;
			break;
		}

		$this->assertTrue($found, 'Audit not found in queue: ' . print_r($values, true));
	}
}
