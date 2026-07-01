<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsuariosControleAcesso extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios', [
            'ativo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
                'after' => 'tipo',
            ],
        ]);

        $this->db->query("UPDATE usuarios SET tipo = 'super_admin' WHERE tipo = 'admin'");
    }

    public function down()
    {
        $this->db->query("UPDATE usuarios SET tipo = 'admin' WHERE tipo = 'super_admin'");
        $this->forge->dropColumn('usuarios', 'ativo');
    }
}
