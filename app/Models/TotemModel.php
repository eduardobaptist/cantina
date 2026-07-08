<?php

namespace App\Models;

use CodeIgniter\Model;

class TotemModel extends Model
{
    protected $table            = 'totens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;

    protected $allowedFields = ['descricao', 'ativo'];

    protected $validationRules = [
        'descricao' => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'descricao' => [
            'required'   => 'A descrição é obrigatória.',
            'min_length' => 'A descrição deve ter pelo menos 2 caracteres.',
            'max_length' => 'A descrição deve ter no máximo 100 caracteres.',
        ],
    ];
}
