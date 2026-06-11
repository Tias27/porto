<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAiMemories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'memory_key' => ['type' => 'VARCHAR', 'constraint' => 64],
            'content' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('memory_key');
        $this->forge->createTable('ai_memories', true);
    }

    public function down()
    {
        $this->forge->dropTable('ai_memories', true);
    }
}
