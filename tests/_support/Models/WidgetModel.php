<?php namespace Tests\Support\Models;

use Tatter\Audits\Traits\AuditsTrait;
use CodeIgniter\Model;
use Faker\Generator;

class WidgetModel extends Model
{
	use AuditsTrait;

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
	 *
	 */
	public function fake(Generator &$faker): object
	{
		return (object) [
			'name'    => $faker->catchPhrase,
			'uid'     => $faker->word,
			'summary' => $faker->sentence,
		];
	}

	/**
	 * Toggle an event callback
	 *
	 *
	 */
	public function useEvent(string $event, bool $active = true): self
	{
		$target        = 'after' . $event;
		$this->$target = $active ? ['audit' . $event] : [];
		return $this;
	}
}
