<?php

namespace App\Controllers;

class PedidoController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();

        $pedidos = $db->table('pedidos p')
            ->select('p.id, p.status, p.totem, p.created_at, p.updated_at')
            ->where('p.deleted_at IS NULL')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($pedidos as &$pedido) {
            $pedido['itens'] = $db->table('pedido_produtos pp')
                ->select('pp.quantidade, pp.preco_unitario, pr.nome')
                ->join('produtos pr', 'pr.id = pp.id_produto')
                ->where('pp.id_pedido', $pedido['id'])
                ->where('pp.deleted_at IS NULL')
                ->get()
                ->getResultArray();

            $pedido['total'] = array_reduce(
                $pedido['itens'],
                fn($carry, $item) => $carry + ($item['quantidade'] * $item['preco_unitario']),
                0
            );
        }

        return view('pages/pedidos/index', ['pedidos' => $pedidos]);
    }
}
