<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EstoqueModel;
use App\Models\ProdutoModel;

class EstoqueController extends BaseController
{

    protected ProdutoModel $produtoModel;
    protected EstoqueModel $estoqueModel;


    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->estoqueModel = new EstoqueModel();
    }

    public function index()
    {
        $produtos = $this->produtoModel->findAll();
        return view('pages/estoque/index', ['produtos' => $produtos]);
    }

    public function adicionar($id)
    {
        $produto = $this->produtoModel->find($id);
        if (!$produto) {
            return redirect()->to(site_url('estoque'))->with('error', 'Produto não encontrado.');
        }

        return view('pages/estoque/adicionar', ['produto' => $produto]);
    }

    public function remover($id)
    {
        $produto = $this->produtoModel->find($id);
        if (!$produto) {
            return redirect()->to(site_url('estoque'))->with('error', 'Produto não encontrado.');
        }

        return view('pages/estoque/remover', ['produto' => $produto]);
    }

    public function salvar()
    {
        $dados = [
            'produto_id' => $this->request->getPost('produto_id'),
            'quantidade' => $this->request->getPost('quantidade'),
            'fornecedor' => $this->request->getPost('fornecedor'),
            'observacao' => $this->request->getPost('observacao'),
            'tipo' => $this->request->getPost('tipo'),
        ];

        $this->estoqueModel->insert($dados);

        $produto = $this->produtoModel->find($dados['produto_id']);
        if ($dados['tipo'] === 'entrada') {
            $produto['estoque'] = $produto['estoque'] + (int)$dados['quantidade'];
        } else if ($dados['tipo'] === 'saida') {
            $produto['estoque'] = $produto['estoque'] - (int)$dados['quantidade'];
        }

        $this->produtoModel->update($produto['id'], $produto);

        return redirect()->to(site_url('estoque'))->with('success', 'Estoque atualizado com sucesso.');
    }

    public function historico($id = null)
    {
        if (empty($id) || is_null($id)) {
            return redirect()->to(site_url('estoque'));
        }

        $produto = $this->produtoModel->find($id);

        if (empty($produto)) {
            return redirect()->to(site_url('estoque'));
        }

        $estoques = $this->
        estoqueModel->where('produto_id', $id)->findAll();

        return view('pages/estoque/historico', 
		        ['estoques' => $estoques, 'produto' => $produto]
        );


    }
}
