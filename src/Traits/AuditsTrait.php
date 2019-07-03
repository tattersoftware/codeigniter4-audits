<?php namespace Tatter\Audits\Traits;

use CodeIgniter\Config\Services;
use Tatter\Audits\Models\AuditModel;

/*** CLASS ***/
trait AuditsTrait
{
	// takes an array of model $returnTypes and returns an array of Audits, arranged by object and event
	// optionally filter by $events (string or array of strings)
	public function getAudits(array $objects, $events = null): array
	{
		if (empty($objects))
			return null;
	
		// get the primary keys from the objects
		$objectIds = array_column($objects, $this->primaryKey);
		
		$audits = new AuditModel();
		$query = $query->where('source', $this->table)
			->whereIn('source_id', $objectIds);
		if (is_string($events))
			$query = $query->where('event', $events);
		elseif (is_array($events))
			$query = $query->whereIn('event', $events);
		
		// index by objectId, event
		$array = [ ];
		while ($audit = $query->getUnbufferedRow()):
			if (empty($array[$audit->{$this->primaryKey}]))
				$array[$audit->{$this->primaryKey}] = [ ];
				
			if (empty($array[$audit->{$this->primaryKey}][$audit->event]))
				$array[$audit->{$this->primaryKey}][$audit->event] = [ ];
			
			$array[$audit->{$this->primaryKey}][$audit->event][] = $audit;
		endwhile;
	
		return $array;
	}
	
	// record successful insert events
	protected function auditInsert(array $data)
	{
		if (! $data['result'])
			return false;

		$audit = [
			'source'    => $this->table,
			'source_id' => $data['result']->connID->insert_id,
			'event'     => 'insert',
			'summary'   => count($data['data']) . ' rows',
		];
		Services::audits()->add($audit);
		
		return $data;
	}
	
	// record successful update events
	protected function auditUpdate(array $data)
	{
		$audit = [
			'source'    => $this->table,
			'source_id' => $data['id'],
			'event'     => 'update',
			'summary'   => count($data['data']) . ' rows',
		];
		Services::audits()->add($audit);
		
		return $data;
	}
	
	// record successful delete events
	protected function auditDelete(array $data)
	{
		if (! $data['result'])
			return false;
		if (empty($data['id']))
			return false;

		$audit = [
			'source'    => $this->table,
			'event'     => 'delete',
			'summary'   => ($data['purge'])? 'purge' : 'soft',
		];
		
		// add an entry for each ID
		$audits = Services::audits();
		foreach ($data['id'] as $id):
			$audit['source_id'] = $id;
			$audits->add($audit);
		endforeach;
		
		return $data;
	}
}
