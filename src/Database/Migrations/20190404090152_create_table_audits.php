<?php namespace Tatter\Audits\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_audits extends Migration
{
	public function up()
	{
		// audit logs
		$fields = [
			'source'        => ['type' => 'varchar', 'constraint' => 63],
			'source_id'     => ['type' => 'int', 'unsigned' => true],
			'user_id'       => ['type' => 'int', 'unsigned' => true, 'null' => true],
			'event'         => ['type' => 'varchar', 'constraint' => 31],
			'summary'       => ['type' => 'varchar', 'constraint' => 255],
			'created_at'    => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey(['source', 'source_id', 'event']);
		$this->forge->addKey(['user_id', 'source', 'event']);
		$this->forge->addKey(['event', 'user_id', 'source', 'source_id']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('audits');
	}

	public function down()
	{
		$this->forge->dropTable('audits');
	}
}
