<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnClientePedidos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pedidos', [
            'cliente' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pedidos', 'cliente');
    }
}
