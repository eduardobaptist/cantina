<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= site_url('totens') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="mb-0 h4">Novo totem</h1>
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
        <form action="<?= site_url('totens/salvar') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="descricao" class="form-label small fw-semibold">Descrição</label>
                <input type="text" name="descricao" id="descricao" class="form-control"
                    value="<?= esc(old('descricao')) ?>"
                    placeholder="Ex: Totem Entrada, Totem Mesa 1..."
                    maxlength="100" required autofocus>
                <div class="form-text">Nome que identifica onde este totem está instalado.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white fw-semibold" style="background-color:#fd7e14">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Cadastrar
                </button>
                <a href="<?= site_url('totens') ?>" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
