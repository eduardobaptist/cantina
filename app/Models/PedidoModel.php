<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table         = 'pedidos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['status', 'cliente', 'totem', 'created_at', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;

    protected $validationRules = [
        'status' => 'required|min_length[2]|max_length[255]',
        'cliente' => 'permit_empty|max_length[100]',
        'totem' => 'permit_empty|max_length[100]',
    ];

    protected $validationMessages = [
        'status' => [
            'required'   => 'O status do pedido é obrigatorio.',
            'min_length' => 'O status deve ter pelo menos 2 caracteres.',
            'max_length' => 'O status deve ter no maximo 255 caracteres.',
        ],
        'cliente' => [
            'max_length' => 'O nome do cliente deve ter no maximo 100 caracteres.',
        ],
        'totem' => [
            'max_length' => 'O nome do totem deve ter no maximo 100 caracteres.',
        ],
    ];
}
