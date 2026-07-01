<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoProdutosModel extends Model
{
    protected $table         = 'pedido_produtos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_pedido', 'id_produto', 'quantidade', 'preco_unitario', 'created_at', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;

    protected $validationRules = [
        'id_pedido' => 'required|integer|greater_than[0]',
        'id_produto' => 'required|integer|greater_than[0]',
        'quantidade' => 'required|integer|greater_than[0]',
        'preco_unitario' => 'required|decimal|greater_than[0]',
    ];

    protected $validationMessages = [
        'id_pedido' => [
            'required'   => 'O ID do pedido é obrigatorio.',
            'integer'    => 'O ID do pedido deve ser um número inteiro.',
            'greater_than' => 'O ID do pedido deve ser maior que zero.',
        ],
    ];
}
