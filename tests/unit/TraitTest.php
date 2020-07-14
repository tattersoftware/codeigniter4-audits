<?php

use Tests\Support\DatabaseTestCase;

class TraitTest extends DatabaseTestCase
{
	public function setUp(): void
	{
		parent::setUp();

	}

	public function testInsertAddsAudit()
	{
		$widget = $this->fabricator->make();

		$result = $this->model->insert($widget);
		$this->assertIsInt($result);

		$expected = [
			'source'     => 'widgets',
			'source_id'  => $result,
			'event'      => 'insert',
			'summary'    => '5 fields',
			'user_id'    => -1,
		];

		$queue = service('audits')->getQueue();

		$this->assertCount(1, $queue);
		$this->seeAudit($expected);
	}
}
