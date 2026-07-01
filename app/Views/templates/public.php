<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome.all.min.css') ?>">

    <style>
        body {
            background-color: #d8dce2;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column">

    <main class="flex-grow-1 d-flex flex-column align-items-center justify-content-center p-3">
        <?= $this->renderSection('conteudo') ?>
    </main>

    <footer class="text-center py-2 w-100 bg-white text-muted" style="border-top:3px solid #fd7e14">
        <small><i class="fa-solid fa-utensils me-1"></i>Cantina &copy; <?= date('Y') ?></small>
    </footer>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>
