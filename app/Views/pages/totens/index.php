<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-tablet-screen-button me-2" style="color:#fd7e14"></i>Totens</h4>
    <a href="<?= site_url('totens/novo') ?>" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i>Novo totem
    </a>
</div>

<?php if (session()->getFlashdata('sucesso')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
<?php endif ?>
<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('erros')) ?></div>
<?php endif ?>

<?php if (!empty($totens)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">ID</th>
                        <th class="text-muted fw-semibold small">Descrição</th>
                        <th class="text-muted fw-semibold small">Status</th>
                        <th class="pe-3 text-muted fw-semibold small">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($totens as $totem): ?>
                        <tr>
                            <td class="ps-3">
                                <span class="badge" style="background:#fff3e0;color:#fd7e14;font-size:.85rem;font-weight:700">
                                    <?= esc($totem['id']) ?>
                                </span>
                            </td>
                            <td class="fw-semibold"><?= esc($totem['descricao']) ?></td>
                            <td>
                                <?php if ((int) $totem['ativo'] === 1): ?>
                                    <span class="badge rounded-pill text-bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill text-bg-secondary">Inativo</span>
                                <?php endif ?>
                            </td>
                            <td class="pe-3">
                                <a href="<?= site_url('totens/editar/' . $totem['id']) ?>"
                                    class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="fa-solid fa-pen fa-xs"></i> Editar
                                </a>
                                <?php if ((int) $totem['ativo'] === 1): ?>
                                    <a href="<?= site_url('totens/desativar/' . $totem['id']) ?>"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-ban fa-xs"></i> Desativar
                                    </a>
                                <?php else: ?>
                                    <a href="<?= site_url('totens/ativar/' . $totem['id']) ?>"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="fa-solid fa-circle-check fa-xs"></i> Ativar
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
    <div class="page-card p-4 text-center text-muted">
        <i class="fa-solid fa-tablet-screen-button fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-3">Nenhum totem cadastrado.</p>
        <a href="<?= site_url('totens/novo') ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus me-1"></i>Cadastrar totem
        </a>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
