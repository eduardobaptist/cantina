<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<h4 class="fw-bold mb-3"><i class="fa-solid fa-receipt me-2" style="color:#fd7e14"></i>Pedidos</h4>

<?php if (!empty($pedidos)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">#</th>
                        <th class="text-muted fw-semibold small">Itens</th>
                        <th class="text-muted fw-semibold small">Total</th>
                        <th class="text-muted fw-semibold small">Status</th>
                        <th class="text-muted fw-semibold small">Totem</th>
                        <th class="pe-3 text-muted fw-semibold small">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <?php
                        $badges = [
                            'aguardando' => 'warning',
                            'em_preparo' => 'primary',
                            'pronto'     => 'success',
                            'cancelado'  => 'danger',
                        ];
                        $cor = $badges[$pedido['status']] ?? 'secondary';
                        ?>
                        <tr>
                            <td class="ps-3 fw-bold" style="color:#fd7e14">
                                #<?= str_pad($pedido['id'], 3, '0', STR_PAD_LEFT) ?>
                            </td>
                            <td>
                                <ul class="mb-0 ps-3 small">
                                    <?php foreach ($pedido['itens'] as $item): ?>
                                        <li><?= esc($item['quantidade']) ?>&times; <?= esc($item['nome']) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </td>
                            <td class="fw-semibold">R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                            <td>
                                <span class="badge text-bg-<?= $cor ?>">
                                    <?= esc(ucfirst(str_replace('_', ' ', $pedido['status']))) ?>
                                </span>
                            </td>
                            <td class="small text-muted">
                                <?= esc($pedido['totem'] ?? '') ?: '—' ?>
                            </td>
                            <td class="pe-3 small text-muted">
                                <?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
    <div class="page-card p-4 text-center text-muted">
        <i class="fa-solid fa-receipt fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-0">Nenhum pedido registrado.</p>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
