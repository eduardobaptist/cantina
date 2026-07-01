<?= $this->extend('templates/public') ?>

<?= $this->section('conteudo') ?>

<div class="w-100 px-3" style="max-width:400px">

    <div class="text-center mb-4">
        <i class="fa-solid fa-utensils fa-2x" style="color:#fd7e14"></i>
        <h5 class="fw-bold mt-2 mb-0">Cantina</h5>
    </div>

    <?php if (session()->getFlashdata('sucesso')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('sucesso') ?></div>
    <?php endif ?>
    <?php if (session()->getFlashdata('erros')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
    <?php endif ?>

    <div class="card shadow-sm" style="border-top:4px solid #fd7e14;border-radius:.5rem">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-4">Entrar</h6>
            <form action="<?= site_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="<?= esc(old('email')) ?>" autocomplete="email">
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label small fw-semibold">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" autocomplete="current-password">
                    <div class="mt-1 text-end">
                        <a href="<?= site_url('recuperar-senha') ?>" class="small text-muted">Esqueci minha senha</a>
                    </div>
                </div>
                <div class="d-grid mt-4">
                    <button class="btn text-white fw-semibold" style="background-color:#fd7e14">
                        <i class="fa-solid fa-right-to-bracket me-1"></i>Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
