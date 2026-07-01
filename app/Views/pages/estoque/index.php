<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<h4 class="fw-bold mb-3"><i class="fa-solid fa-warehouse me-2" style="color:#fd7e14"></i>Estoque</h4>

<?php if (!empty($produtos)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">ID</th>
                        <th class="text-muted fw-semibold small">Nome</th>
                        <th class="text-muted fw-semibold small">Categoria</th>
                        <th class="text-muted fw-semibold small">Em estoque</th>
                        <th class="pe-3 text-muted fw-semibold small">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <?php $baixo = $produto['estoque'] <= $produto['estoque_limite']; ?>
                        <tr>
                            <td class="ps-3 text-muted small">#<?= esc($produto['id']) ?></td>
                            <td class="fw-semibold"><?= esc($produto['nome']) ?></td>
                            <td><span class="badge rounded-pill text-bg-light text-muted"><?= esc(ucfirst($produto['categoria'])) ?></span></td>
                            <td>
                                <span class="fw-semibold <?= $baixo ? 'text-danger' : '' ?>">
                                    <?= esc($produto['estoque']) ?>
                                </span>
                                <?php if ($baixo): ?>
                                    <span class="badge text-bg-danger ms-1">Baixo</span>
                                <?php endif ?>
                            </td>
                            <td class="pe-3">
                                <a href="<?= site_url('estoque/adicionar/' . $produto['id']) ?>"
                                    class="btn btn-sm btn-outline-success me-1">
                                    <i class="fa-solid fa-plus fa-xs"></i> Adicionar
                                </a>
                                <a href="<?= site_url('estoque/remover/' . $produto['id']) ?>"
                                    class="btn btn-sm btn-outline-warning me-1">
                                    <i class="fa-solid fa-minus fa-xs"></i> Remover
                                </a>
                                <a href="<?= site_url('estoque/historico/' . $produto['id']) ?>"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-clock-rotate-left fa-xs"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
    <div class="page-card p-4 text-center text-muted">
        <i class="fa-solid fa-warehouse fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-3">Nenhum produto cadastrado.</p>
        <a href="<?= site_url('produtos/novo') ?>" class="btn btn-primary btn-sm">Cadastrar produto</a>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
