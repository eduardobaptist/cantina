<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('estoque') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">
        <i class="fa-solid fa-clock-rotate-left me-2" style="color:#fd7e14"></i>
        Histórico — <?= esc($produto['nome'] ?? '') ?>
    </h4>
</div>

<?php if (!empty($estoques)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">Data</th>
                        <th class="text-muted fw-semibold small">Tipo</th>
                        <th class="text-muted fw-semibold small">Qtd</th>
                        <th class="text-muted fw-semibold small">Fornecedor / Motivo</th>
                        <th class="pe-3 text-muted fw-semibold small">Observação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estoques as $estoque): ?>
                        <tr>
                            <td class="ps-3 small text-muted">
                                <?= date('d/m/Y H:i', strtotime($estoque['created_at'])) ?>
                            </td>
                            <td>
                                <?php if ($estoque['tipo'] === 'entrada'): ?>
                                    <span class="badge text-bg-success">
                                        <i class="fa-solid fa-arrow-up fa-xs me-1"></i>Entrada
                                    </span>
                                <?php else: ?>
                                    <span class="badge text-bg-danger">
                                        <i class="fa-solid fa-arrow-down fa-xs me-1"></i>Saída
                                    </span>
                                <?php endif ?>
                            </td>
                            <td class="fw-semibold"><?= esc($estoque['quantidade']) ?></td>
                            <td><?= esc($estoque['fornecedor']) ?: '<span class="text-muted">—</span>' ?></td>
                            <td class="pe-3 small text-muted"><?= esc($estoque['observacao']) ?: '—' ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
    <div class="page-card p-4 text-center text-muted">
        <i class="fa-solid fa-clock-rotate-left fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-0">Nenhuma movimentação registrada.</p>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
