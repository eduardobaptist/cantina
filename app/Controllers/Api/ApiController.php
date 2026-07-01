<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PedidoModel;
use App\Models\PedidoProdutosModel;
use App\Models\ProdutoModel;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function api_status()
    {
        return $this->respond([], 200, 'Api funcionando');
    }

    public function get_produtos()
    {
        $apiKey = $this->request->getHeaderLine('X-API-Key');

        if ($apiKey !== env('API_KEY')) {
            return $this->respond([], 401);
        }

        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->findAll();
        return $this->respond($produtos, 200);
    }

    public function checkout()
    {
        $apiKey = $this->request->getHeaderLine('X-API-Key');

        if (!$apiKey) {
            return $this->failUnauthorized('API Key não informada.');
        }

        if ($apiKey !== env('API_KEY')) {
            return $this->failUnauthorized('API Key inválida.');
        }

        $dados = $this->request->getJSON(true);

        if (!$dados) {
            return $this->failValidationErrors('JSON inválido.');
        }

        if (!isset($dados['produtos']) || empty($dados['produtos'])) {
            return $this->failValidationErrors('O pedido precisa ter pelo menos um produto.');
        }

        $pedidoModel = new PedidoModel();
        $pedidoProdutosModel = new PedidoProdutosModel();
        $db = \Config\Database::connect();

        $db->transStart();

        $idPedido = $pedidoModel->insert([
            'status' => $dados['status'] ?? 'aguardando',
            'cliente' => $dados['cliente'] ?? null,
            'totem' => $dados['totem'] ?? null,
        ]);

        foreach ($dados['produtos'] as $produto) {
            $pedidoProdutosModel->insert([
                'id_pedido'      => $idPedido,
                'id_produto'     => $produto['id_produto'],
                'quantidade'     => $produto['quantidade'],
                'preco_unitario' => $produto['preco_unitario'],
            ]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return $this->failServerError('Erro ao cadastrar pedido.');
        }

        return $this->respondCreated([
            'status'    => true,
            'message'   => 'Pedido cadastrado com sucesso.',
            'id_pedido' => $idPedido,
        ]);
    }

    public function get_pedidos()
    {
        $status = $this->request->getGet('status');

        $db = \Config\Database::connect();

        $pedidos = $db->table('pedidos')
            ->where('deleted_at IS NULL')
            ->where('status', $status)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($pedidos as &$pedido) {
            $itens = $db->table('pedido_produtos pp')
                ->select('pp.quantidade, pr.nome')
                ->join('produtos pr', 'pr.id = pp.id_produto')
                ->where('pp.id_pedido', $pedido['id'])
                ->where('pp.deleted_at IS NULL')
                ->get()
                ->getResultArray();

            $pedido['itens']      = $itens;
            $pedido['started_at'] = $pedido['updated_at'];
        }

        return $this->respond($pedidos);
    }

    public function update_pedido_status(int $id)
    {
        $dados = $this->request->getJSON(true);

        if (!$dados || !isset($dados['status'])) {
            return $this->failValidationErrors('Campo status é obrigatório.');
        }

        $statusValidos = ['aguardando', 'em_preparo', 'pronto', 'cancelado'];
        if (!in_array($dados['status'], $statusValidos)) {
            return $this->failValidationErrors('Status inválido. Use: ' . implode(', ', $statusValidos));
        }

        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado.');
        }

        $pedidoModel->update($id, ['status' => $dados['status']]);

        return $this->respond([
            'status'  => true,
            'message' => 'Status atualizado para "' . $dados['status'] . '".',
        ]);
    }
}
