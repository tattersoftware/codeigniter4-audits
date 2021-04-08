<?php namespace Tatter\Audits\Models;

use CodeIgniter\Model;
use Tatter\Audits\Entities\Audit;

class AuditModel extends Model
{
	protected $table      = 'audits';
	protected $primaryKey = 'id';
	protected $returnType = Audit::class;

	protected $useTimestamps  = false;
	protected $useSoftDeletes = false;
	protected $skipValidation = true;

	protected $allowedFields = ['source', 'source_id', 'user_id', 'event', 'summary', 'created_at'];

}
