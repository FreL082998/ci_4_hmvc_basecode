<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestTable extends Migration
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
            'title' => [
                'type'          =>  'VARCHAR',
                'constraint'    =>  100,
            ],
            'description' => [
                'type'          =>  'TEXT',
                'null'          =>  true,
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
        $this->forge->addKey('title');
        $this->forge->addKey('created_at');
        $this->forge->createTable('test');
    }

    public function down()
    {
        $this->forge->dropTable('test');
    }
}
