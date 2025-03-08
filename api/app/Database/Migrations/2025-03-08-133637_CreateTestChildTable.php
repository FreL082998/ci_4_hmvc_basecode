<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestChildTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'test_id' => [
                'type'          =>  'INT',
                'constraint'    =>  11,
                'unsigned'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('test_id', 'test', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('test_id');
        $this->forge->createTable('test_child');
    }

    public function down()
    {
        $this->forge->dropTable('test_child');
    }
}
