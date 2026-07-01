<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ProdutoModel;


class ProdutoController extends BaseController
{

    protected ProdutoModel $model;

    public function __construct()
    {
        $this->model = new ProdutoModel();
    }

    //Listar todos os produtos
    public function index(): string
    {

        $busca = $this->request->getGet("busca");
        $preco = $this->request->getGet("preco");
        $order = $this->request->getGet("order");

        if ($preco) {
            switch ($preco) {
                case 'baixo':
                    $this->model->where("preco < ", 5);
                    break;
                case 'medio':
                    $this->model->where("preco >= ", 5);
                    $this->model->where("preco <= ", 10);
                    break;
                case 'alto':
                    $this->model->where("preco > ", 10);
                    break;
            }
        }


        $this->model->orderBy("preco", $order ?? "asc");


        if ($busca) {
            $this->model->like("nome", $busca);
        }

        $produtos = $this->model->paginate(5);

        return view(
            'pages/produtos/index',
            [
                'titulo' => 'Lista de produtos',
                'produtos' => $produtos,
                'pager' => $this->model->pager,
                'busca' => $busca,
                'preco' => $preco,
                'order' => $order
            ]
        );
    }

    public function novo(): string
    {
        return view("pages/produtos/cadastro", ["produto" => null]);
    }

    public function salvar()
    {
        $dados = [
            "nome" => $this->request->getPost("nome"),
            "preco" => $this->request->getPost("preco"),
            "categoria" => $this->request->getPost("categoria")
        ];

        $regrasFoto = [
            "foto" => "is_image[foto]" .
                "|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]" .
                "|ext_in[foto,jpg,jpeg,png,gif]|max_size[foto,2048]"
        ];

        $errors = [];

        if (!$this->model->validate($dados)) {
            $errors = array_merge($errors, $this->model->errors());
        }

        if (!$this->validate($regrasFoto)) {
            $errors = array_merge($errors, $this->validator->getErrors());
        }

        if (!empty($errors)) {
            //dd($errors);
            return redirect()->back()->withInput()->with("errors", $errors);
        }

        $foto = $this->request->getFile("foto");

        if ($foto && $foto->isValid()) {
            $random = $foto->getRandomName();

            $foto->move(FCPATH . "uploads/produtos", $random);

            $dados["foto"] = $random;

            if (!$this->model->insert($dados)) {
                unlink(FCPATH . "uploads/produtos", $random);
                return redirect()->back()->withInput()->with("errors", $$this->model->errors());
            }
        }

        return redirect()->to(site_url("produtos"));
    }

    public function editar(int $id): string
    {
        $produto = $this->model->find($id);
        return view("pages/produtos/editar", ["produto" => $produto]);
    }

    public function atualizar($id)
    {
        $dados = [
            'nome' => $this->request->getPost('nome'),
            'preco' => $this->request->getPost('preco'),
            'categoria' => $this->request->getPost('preco'),
        ];

        if (!$this->model->update($id, $dados)) {
            return view('pages/produtos/editar', [
                'titulo' => 'Editar produto',
                'produto' => $this->model->find($id),
                'errors' => $this->model->errors(),
            ]);

        }
        return redirect()->to(site_url('produtos'));
    }

    public function excluir(int $id)
    {
        $produto = $this->model->find($id);
        unlink(FCPATH . "uploads/produtos/" . $produto["foto"]);
        $this->model->delete($id);
        return redirect()->to(site_url("produtos"));
    }
}
