<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-box me-2" style="color:#fd7e14"></i>Produtos</h4>
    <a href="<?= site_url('produtos/novo') ?>" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i>Novo produto
    </a>
</div>

<div class="page-card p-3 mb-3">
    <form action="<?= site_url('produtos') ?>" method="get">
        <div class="row g-2">
            <div class="col-12 col-md-4">
                <input type="text" placeholder="Buscar por nome..." value="<?= esc($busca ?? '') ?>"
                    class="form-control form-control-sm" name="busca">
            </div>
            <div class="col-6 col-md-3">
                <select name="preco" class="form-select form-select-sm">
                    <option value=""     <?= !$preco              ? 'selected' : '' ?>>Todos os preços</option>
                    <option value="baixo" <?= $preco == 'baixo'   ? 'selected' : '' ?>>Abaixo de R$ 5</option>
                    <option value="medio" <?= $preco == 'medio'   ? 'selected' : '' ?>>R$ 5 a R$ 10</option>
                    <option value="alto"  <?= $preco == 'alto'    ? 'selected' : '' ?>>Acima de R$ 10</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="order" class="form-select form-select-sm">
                    <option value="asc"  <?= $order == 'asc'  ? 'selected' : '' ?>>Preço crescente</option>
                    <option value="desc" <?= $order == 'desc' ? 'selected' : '' ?>>Preço decrescente</option>
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <?php if ($busca || $preco): ?>
                    <a href="<?= site_url('produtos') ?>" class="small text-danger">Limpar</a>
                <?php endif ?>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($produtos)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">ID</th>
                        <th class="text-muted fw-semibold small">Nome</th>
                        <th class="text-muted fw-semibold small">Categoria</th>
                        <th class="text-muted fw-semibold small">Preço</th>
                        <th class="text-muted fw-semibold small text-center">Foto</th>
                        <th class="pe-3 text-muted fw-semibold small">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td class="ps-3 text-muted small">#<?= esc($produto['id']) ?></td>
                            <td class="fw-semibold"><?= esc($produto['nome']) ?></td>
                            <td><span class="badge rounded-pill text-bg-light text-muted"><?= esc(ucfirst($produto['categoria'])) ?></span></td>
                            <td class="fw-semibold" style="color:#fd7e14">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td class="text-center">
                                <?php if (!empty($produto['foto'])): ?>
                                    <a href="<?= site_url('uploads/produtos/' . $produto['foto']) ?>" target="_blank">
                                        <img src="<?= site_url('uploads/produtos/' . $produto['foto']) ?>"
                                            style="width:48px;height:48px;object-fit:cover;border-radius:6px" alt="">
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif ?>
                            </td>
                            <td class="pe-3">
                                <a href="<?= site_url('produtos/editar/' . $produto['id']) ?>"
                                    class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="fa-solid fa-pen fa-xs"></i> Editar
                                </a>
                                <a href="<?= site_url('produtos/excluir/' . $produto['id']) ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick='return confirm("Excluir produto?")'>
                                    <i class="fa-solid fa-trash fa-xs"></i>
                                </a>
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
        <i class="fa-solid fa-box-open fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-3">Nenhum produto cadastrado.</p>
        <a href="<?= site_url('produtos/novo') ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus me-1"></i>Cadastrar produto
        </a>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
