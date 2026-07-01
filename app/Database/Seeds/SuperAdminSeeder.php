<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $email = 'admin@iffar.edu.br';

        $usuario = $this->db->table('usuarios')->where('email', $email)->get()->getRowArray();

        $dados = [
            'email' => $email,
            'senha_hash' => password_hash('admin', PASSWORD_DEFAULT),
            'tipo' => 'super_admin',
            'ativo' => 1,
        ];

        if ($usuario) {
            $this->db->table('usuarios')->where('id', $usuario['id'])->update($dados);
        } else {
            $dados['created_at'] = date('Y-m-d H:i:s');
            $dados['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('usuarios')->insert($dados);
        }
    }
}
