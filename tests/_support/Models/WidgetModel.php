<?php namespace Tests\Support\Models;

use CodeIgniter\Model;
use Faker\Generator;

class WidgetModel extends Model
{
	use \Tatter\Audits\Traits\AuditsTrait;

	protected $table      = 'widgets';
	protected $primaryKey = 'id';
	protected $returnType = 'object';

	protected $useTimestamps  = true;
	protected $useSoftDeletes = true;
	protected $skipValidation = true;

	protected $allowedFields = ['name', 'uid', 'summary'];

	protected $afterInsert = ['auditInsert'];
	protected $afterUpdate = ['auditUpdate'];
	protected $afterDelete = ['auditDelete'];

	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return stdClass
	 */
	public function fake(Generator &$faker): stdClass
	{
		return new stdClass([
			'name'    => $faker->catchPhrase,
			'uid'     => $faker->word,
			'summary' => $faker->sentence,
		]);
	}

	/**
	 * Toggle an event callback
	 *
	 * @param string $event
	 * @param bool $active
	 *
	 * @return self
	 */
	public function useEvent(string $event, bool $active = true): self
	{
		$target        = 'after' . $event;
		$this->$target = $active ? ['audit' . $event] : [];
		return $this;
	}
}
