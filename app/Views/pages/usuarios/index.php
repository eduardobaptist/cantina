<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-users me-2" style="color:#fd7e14"></i>Usuários</h4>
    <a href="<?= site_url('usuarios/novo') ?>" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i>Novo usuário
    </a>
</div>

<?php if (session()->getFlashdata('sucesso')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
<?php endif ?>
<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('erros')) ?></div>
<?php endif ?>

<div class="page-card p-3 mb-3">
    <form action="<?= site_url('usuarios') ?>" method="get">
        <div class="row g-2">
            <div class="col-12 col-md-6">
                <input type="text" placeholder="Buscar por e-mail..." value="<?= esc($busca ?? '') ?>"
                    class="form-control form-control-sm" name="busca">
            </div>
            <div class="col-12 col-md-2 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <?php if ($busca): ?>
                    <a href="<?= site_url('usuarios') ?>" class="small text-danger">Limpar</a>
                <?php endif ?>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($usuarios)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">ID</th>
                        <th class="text-muted fw-semibold small">E-mail</th>
                        <th class="text-muted fw-semibold small">Papel</th>
                        <th class="text-muted fw-semibold small">Status</th>
                        <th class="pe-3 text-muted fw-semibold small">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td class="ps-3 text-muted small">#<?= esc($usuario['id']) ?></td>
                            <td class="fw-semibold"><?= esc($usuario['email']) ?></td>
                            <td>
                                <span class="badge rounded-pill text-bg-light text-muted">
                                    <?= $usuario['tipo'] === 'super_admin' ? 'Admin' : 'Usuário' ?>
                                </span>
                            </td>
                            <td>
                                <?php if ((int) $usuario['ativo'] === 1): ?>
                                    <span class="badge rounded-pill text-bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill text-bg-danger">Bloqueado</span>
                                <?php endif ?>
                            </td>
                            <td class="pe-3">
                                <a href="<?= site_url('usuarios/editar/' . $usuario['id']) ?>"
                                    class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="fa-solid fa-pen fa-xs"></i> Editar
                                </a>
                                <?php if ((int) $usuario['ativo'] === 1): ?>
                                    <a href="<?= site_url('usuarios/bloquear/' . $usuario['id']) ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick='return confirm("Bloquear este usuário?")'>
                                        <i class="fa-solid fa-lock fa-xs"></i> Bloquear
                                    </a>
                                <?php else: ?>
                                    <a href="<?= site_url('usuarios/desbloquear/' . $usuario['id']) ?>"
                                        class="btn btn-sm btn-outline-success"
                                        onclick='return confirm("Desbloquear este usuário?")'>
                                        <i class="fa-solid fa-lock-open fa-xs"></i> Desbloquear
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3"><?= $pager->links('default', 'template_pager') ?></div>

<?php else: ?>
    <div class="page-card p-4 text-center text-muted">
        <i class="fa-solid fa-users fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-3">Nenhum usuário encontrado.</p>
        <a href="<?= site_url('usuarios/novo') ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus me-1"></i>Cadastrar usuário
        </a>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
