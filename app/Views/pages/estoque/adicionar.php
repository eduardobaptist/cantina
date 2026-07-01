<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= site_url('estoque') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="mb-0 h4">Adicionar ao estoque</h1>
</div>

<?php if (!empty($produto)): ?>

    <div class="d-flex align-items-center gap-2 mb-4">
        <span class="fw-bold fs-5"><?= esc($produto['nome']) ?></span>
        <span class="badge text-bg-secondary"><?= esc($produto['estoque']) ?> em estoque</span>
    </div>

    <div class="card shadow-sm" style="border-top:4px solid #198754;border-radius:.5rem;max-width:500px">
        <div class="card-body p-4">
            <form action="<?= site_url('estoque/salvar') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                <input type="hidden" name="tipo" value="entrada">

                <div class="mb-3">
                    <label for="quantidade" class="form-label small fw-semibold">Quantidade a adicionar</label>
                    <input type="number" name="quantidade" id="quantidade" class="form-control"
                        value="<?= old('quantidade') ?? 1 ?>" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="fornecedor" class="form-label small fw-semibold">Fornecedor</label>
                    <input type="text" name="fornecedor" id="fornecedor" class="form-control"
                        value="<?= esc(old('fornecedor')) ?>">
                </div>
                <div class="mb-4">
                    <label for="observacao" class="form-label small fw-semibold">Observação</label>
                    <input type="text" name="observacao" id="observacao" class="form-control"
                        value="<?= esc(old('observacao')) ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success fw-semibold">
                        <i class="fa-solid fa-plus me-1"></i>Adicionar
                    </button>
                    <a href="<?= site_url('estoque') ?>" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-warning">Produto não encontrado.</div>
    <a href="<?= site_url('produtos/novo') ?>" class="btn btn-primary">Cadastrar produto</a>
<?php endif ?>

<?= $this->endSection() ?>
