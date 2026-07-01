<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UsuarioModel;


class UsuarioController extends BaseController
{

    protected UsuarioModel $model;

    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    public function index(): string
    {
        $busca = $this->request->getGet("busca");

        if ($busca) {
            $this->model->like("email", $busca);
        }

        $this->model->orderBy("email", "asc");

        $usuarios = $this->model->paginate(10);

        return view(
            "pages/usuarios/index",
            [
                "usuarios" => $usuarios,
                "pager" => $this->model->pager,
                "busca" => $busca,
            ]
        );
    }

    public function novo(): string
    {
        return view("pages/usuarios/cadastro");
    }

    public function salvar()
    {
        $email = $this->request->getPost("email");
        $senha = $this->request->getPost("senha");
        $tipo = $this->request->getPost("tipo");

        $dados = [
            "email" => $email,
            "tipo" => $tipo,
        ];

        $errors = [];

        if (!$this->model->validate($dados)) {
            $errors = array_merge($errors, $this->model->errors());
        }

        if ($email && $this->model->where("email", $email)->first()) {
            $errors["email"] = "Já existe um usuário com esse e-mail.";
        }

        if (!$senha || strlen($senha) < 6) {
            $errors["senha"] = "A senha deve ter pelo menos 6 caracteres.";
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with("errors", $errors);
        }

        $dados["senha_hash"] = password_hash($senha, PASSWORD_DEFAULT);
        $dados["ativo"] = 1;

        if (!$this->model->insert($dados)) {
            return redirect()->back()->withInput()->with("errors", $this->model->errors());
        }

        return redirect()->to("usuarios")->with("sucesso", "Usuário criado com sucesso.");
    }

    public function editar(int $id): string
    {
        $usuario = $this->model->find($id);

        if (!$usuario) {
            return redirect()->to("usuarios")->with("erros", "Usuário não encontrado.");
        }

        return view("pages/usuarios/editar", ["usuario" => $usuario]);
    }

    public function atualizar(int $id)
    {
        $usuario = $this->model->find($id);

        if (!$usuario) {
            return redirect()->to("usuarios")->with("erros", "Usuário não encontrado.");
        }

        $email = $this->request->getPost("email");
        $senha = $this->request->getPost("senha");
        $tipo = $this->request->getPost("tipo");

        $dados = [
            "email" => $email,
            "tipo" => $tipo,
        ];

        $errors = [];

        if (!$this->model->validate($dados)) {
            $errors = array_merge($errors, $this->model->errors());
        }

        if ($email && $this->model->where("email", $email)->where("id !=", $id)->first()) {
            $errors["email"] = "Já existe um usuário com esse e-mail.";
        }

        if ($senha && strlen($senha) < 6) {
            $errors["senha"] = "A senha deve ter pelo menos 6 caracteres.";
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with("errors", $errors);
        }

        if ($senha) {
            $dados["senha_hash"] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $this->model->update($id, $dados);

        return redirect()->to("usuarios")->with("sucesso", "Usuário atualizado com sucesso.");
    }

    public function bloquear(int $id)
    {
        if ($id === (int) session()->get("user")["id"]) {
            return redirect()->to("usuarios")->with("erros", "Você não pode bloquear seu próprio usuário.");
        }

        $this->model->update($id, ["ativo" => 0]);

        return redirect()->to("usuarios")->with("sucesso", "Usuário bloqueado com sucesso.");
    }

    public function desbloquear(int $id)
    {
        $this->model->update($id, ["ativo" => 1]);

        return redirect()->to("usuarios")->with("sucesso", "Usuário desbloqueado com sucesso.");
    }

    public function perfil(): string
    {
        $usuario = $this->model->find(session()->get("user")["id"]);

        return view("pages/usuarios/perfil", ["usuario" => $usuario]);
    }

    public function atualizarPerfil()
    {
        $id = session()->get("user")["id"];
        $email = $this->request->getPost("email");
        $senha = $this->request->getPost("senha");

        $dados = ["email" => $email];

        $errors = [];

        if (!$this->model->validate($dados)) {
            $errors = array_merge($errors, $this->model->errors());
        }

        if ($email && $this->model->where("email", $email)->where("id !=", $id)->first()) {
            $errors["email"] = "Já existe um usuário com esse e-mail.";
        }

        if ($senha && strlen($senha) < 6) {
            $errors["senha"] = "A senha deve ter pelo menos 6 caracteres.";
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with("errors", $errors);
        }

        if ($senha) {
            $dados["senha_hash"] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $this->model->update($id, $dados);

        session()->set("user", $this->model->find($id));

        return redirect()->to("perfil")->with("sucesso", "Dados atualizados com sucesso.");
    }

    public function login()
    {
        return view("pages/auth/login");
    }

    public function autenticar()
    {
        $email = $this->request->getPost("email");
        $senha = $this->request->getPost("senha");

        $user = $this->model->where("email", $email)->first();

        if ($user && !(int) $user["ativo"]) {
            return redirect()->to("login")->with("erros", "Usuário bloqueado.")->withInput();
        }

        if ($user && password_verify($senha, $user["senha_hash"])) {
            session()->set("logado", true);
            session()->set("user", $user);

            return redirect()->to("produtos");
        } else {
            return redirect()->to("login")->with("erros", "Usuário ou senha inválidos.")->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to("login");
    }

    public function esqueciSenha(): string
    {
        return view("pages/auth/esqueci_senha.php");
    }

    public function esqueciSenhaSubmit()
    {
        $email = $this->request->getPost("email");

        if (!$email) {
            return redirect()->back()->withInput()->with("erros", "E-mail é obrigatório.");
        }

        $user = $this->model->where("email", $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with("erros", "Nenhum usuário cadastrado com esse e-mail.");
        }

        $token = bin2hex(random_bytes(50));

        $resetLink = site_url("redefinir-senha/" . $token);

        $sender = \Config\Services::email();
        $sender->setFrom('cantina.panambi@iffaroupilha.edu.br', 'Cantina - IFFar Campus Panambi');
        $sender->setTo($email);
        $sender->setSubject('Recuperação de senha');
        $sender->setMessage('
            <h2>Recuperar Senha</h2>

            <p>Olá,</p>

            <p>Clique no link abaixo para redefinir sua senha:</p>

            <p><a href="' . $resetLink . '">Redefinir Senha</a></p>

            <p>Este link expira em 1 hora.</p>

            <p>Se você não solicitou isso, ignore este email.</p>');

        if ($sender->send()) {
            $dataExpiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->model->update($user['id'], [
                'reset_token' => $token,
                'reset_token_date' => $dataExpiracao
            ]);

            return redirect()->back()->withInput()->with("sucesso", "E-mail enviado com sucesso!");
        } else {
            return redirect()->back()->withInput()->with("erros", "Ocorreu um erro ao enviar o e-mail. Teste novamente");
        }

    }

    public function redefinirSenha(string $token)
    {
        $user = $this->model->where("reset_token", $token)->first();

        if (!$user) {
            return redirect()->to("login")->with("erros", "Link de recuperação infálido.");
        }

        return view("pages/auth/redefinir_senha.php", ['token' => $token]);
    }

    public function redefinirSenhaSubmit()
    {
        $token = $this->request->getPost("token");
        $senha = $this->request->getPost("senha");

        if (!$senha) {
            return redirect()->back()->withInput()->with("erros", "Defina uma nova senha.");
        } else if (!$token) {
            return redirect()->back()->withInput()->with("erros", "Link de recuperação inválido.");
        }

        $user = $this->model->where("reset_token", $token)->first();

        if (!$user) {
            return redirect()->to("login")->with("erros", "Token inválido.");
        }

        $agora = date('Y-m-d H:i:s');
        if ($agora > $user['reset_token_date']) {
            return redirect()->to("login")->with("erros", "Link de recuperação expirado.");
        }

        $this->model->update($user['id'], [
            'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expiration' => null
        ]);

        return redirect()->to("login")->with("sucesso", "Senha redefinida com sucesso!");
    }

    public function erro401(): string
    {
        return view("errors/custom/error_401");
    }
}