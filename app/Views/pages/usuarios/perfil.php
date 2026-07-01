<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <h1 class="mb-0 h4"><i class="fa-solid fa-user-gear me-2" style="color:#fd7e14"></i>Meu perfil</h1>
</div>

<?php if (session()->getFlashdata('sucesso')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
<?php endif ?>

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
        <form method="post" action="<?= site_url('perfil') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold">E-mail</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="<?= esc(old('email', $usuario['email'])) ?>" required>
            </div>

            <div class="mb-4">
                <label for="senha" class="form-label small fw-semibold">Nova senha</label>
                <input type="password" name="senha" id="senha" class="form-control">
                <small class="text-muted">Deixe em branco para manter a atual</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white fw-semibold" style="background-color:#fd7e14">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Salvar alterações
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
