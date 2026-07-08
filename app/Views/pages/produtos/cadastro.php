<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= site_url('produtos') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="mb-0 h4">Novo produto</h1>
</div>

<?php if (!empty(session()->getFlashdata('errors'))): ?>
    <div class="alert alert-danger mb-3">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="card shadow-sm" style="border-top:4px solid #fd7e14;border-radius:.5rem">
    <div class="card-body p-4">
        <form action="<?= site_url('produtos/salvar') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3 mb-3">
                <div class="col-7">
                    <label for="nome" class="form-label small fw-semibold">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control"
                        value="<?= esc(old('nome')) ?>" required>
                </div>
                <div class="col-5">
                    <label for="preco" class="form-label small fw-semibold">Preço (R$)</label>
                    <input type="number" name="preco" id="preco" step="0.01" class="form-control"
                        value="<?= esc(old('preco')) ?>" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label for="categoria" class="form-label small fw-semibold">Categoria</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="lanches">Lanches</option>
                        <option value="bebidas">Bebidas</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="foto" class="form-label small fw-semibold">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white fw-semibold" style="background-color:#fd7e14">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Cadastrar
                </button>
                <a href="<?= site_url('produtos') ?>" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
