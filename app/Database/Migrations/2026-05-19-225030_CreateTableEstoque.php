<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableEstoque extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'produto_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'fornecedor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'observacao' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('estoques');
    }

    public function down()
    {
        $this->forge->dropTable('estoques');
    }
}
