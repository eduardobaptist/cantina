<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center">

    <div class="w-100" style="max-width: 500px;">

        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h1 class="display-1 text-danger mb-2">401</h1>
                <h2 class="h4 mb-3">Acesso não autorizado</h2>
                <p class="text-muted mb-4">Você não tem permissão para acessar esse recurso.</p>

                <a href="<?= previous_url() ?>" class="btn btn-link">Voltar para a página anterior</a>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>