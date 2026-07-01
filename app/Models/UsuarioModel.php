<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['id', 'email', 'senha_hash', 'tipo', 'ativo', 'reset_token', 'reset_token_date'];

    protected $useTimestamps = true;

    protected $validationRules = [
        'email' => 'required|valid_email',
        'tipo'  => 'permit_empty|in_list[super_admin,usuario]',
    ];

    protected $validationMessages = [
        'email' => [
            'required'    => 'O e-mail é obrigatório.',
            'valid_email' => 'Informe um e-mail válido.',
        ],
        'tipo' => [
            'in_list' => 'Papel de usuário inválido.',
        ],
    ];
}
