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
            <h6 class="fw-bold mb-1">Recuperar senha</h6>
            <p class="text-muted small mb-4">Enviaremos um link de redefinição para o seu e-mail.</p>
            <form action="<?= site_url('recuperar-senha') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="<?= esc(old('email')) ?>" required>
                </div>
                <div class="d-grid mt-4">
                    <button class="btn text-white fw-semibold" style="background-color:#fd7e14">
                        <i class="fa-solid fa-paper-plane me-1"></i>Enviar link
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="<?= site_url('login') ?>" class="small text-muted text-decoration-none">
            <i class="fa-solid fa-arrow-left me-1"></i>Voltar ao login
        </a>
    </div>

</div>

<?= $this->endSection() ?>
