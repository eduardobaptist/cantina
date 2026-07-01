<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnTotemPedidos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pedidos', [
            'totem' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'cliente',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pedidos', 'totem');
    }
}
