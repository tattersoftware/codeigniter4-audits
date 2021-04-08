<?php namespace Tatter\Audits\Entities;

use CodeIgniter\Entity;

class Audit extends Entity
{
	protected $table      = 'audits';
	protected $primaryKey = 'id';

	protected $dates = ['created_at'];
	protected $casts = [
		'source_id' => 'int',
		'user_id'   => 'int',
	];
}
