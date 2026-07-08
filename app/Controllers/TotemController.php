<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TotemModel;

class TotemController extends BaseController
{
    protected TotemModel $model;

    public function __construct()
    {
        $this->model = new TotemModel();
    }

    public function index(): string
    {
        $totens = $this->model->orderBy('id', 'ASC')->findAll();

        return view('pages/totens/index', ['totens' => $totens]);
    }

    public function novo(): string
    {
        return view('pages/totens/cadastro');
    }

    public function salvar()
    {
        $descricao = $this->request->getPost('descricao');

        if (!$this->model->validate(['descricao' => $descricao])) {
            session()->setFlashdata('errors', $this->model->errors());
            return redirect()->back()->withInput();
        }

        $this->model->insert(['descricao' => $descricao, 'ativo' => 1]);

        session()->setFlashdata('sucesso', 'Totem cadastrado com sucesso.');
        return redirect()->to(site_url('totens'));
    }

    public function editar(int $id): string
    {
        $totem = $this->model->find($id);

        if (!$totem) {
            return redirect()->to(site_url('totens'));
        }

        return view('pages/totens/editar', ['totem' => $totem]);
    }

    public function atualizar(int $id)
    {
        $totem = $this->model->find($id);

        if (!$totem) {
            return redirect()->to(site_url('totens'));
        }

        $descricao = $this->request->getPost('descricao');

        if (!$this->model->validate(['descricao' => $descricao])) {
            session()->setFlashdata('errors', $this->model->errors());
            return redirect()->back()->withInput();
        }

        $this->model->update($id, ['descricao' => $descricao]);

        session()->setFlashdata('sucesso', 'Totem atualizado com sucesso.');
        return redirect()->to(site_url('totens'));
    }

    public function ativar(int $id)
    {
        $this->model->update($id, ['ativo' => 1]);
        session()->setFlashdata('sucesso', 'Totem ativado.');
        return redirect()->to(site_url('totens'));
    }

    public function desativar(int $id)
    {
        $this->model->update($id, ['ativo' => 0]);
        session()->setFlashdata('sucesso', 'Totem desativado.');
        return redirect()->to(site_url('totens'));
    }
}
