<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome.all.min.css') ?>">

    <style>
        body { background-color: #d8dce2; }

        /* Botão primário laranja em todo o admin */
        .btn-primary {
            background-color: #fd7e14;
            border-color: #fd7e14;
            color: #fff;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #e8650a;
            border-color: #e8650a;
            color: #fff;
        }
        .btn-outline-primary {
            color: #fd7e14;
            border-color: #fd7e14;
        }
        .btn-outline-primary:hover {
            background-color: #fd7e14;
            border-color: #fd7e14;
            color: #fff;
        }

        /* Card padrão das páginas internas */
        .page-card {
            background: #fff;
            border-radius: .5rem;
            border-top: 4px solid #fd7e14;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }

        /* Layout principal */
        .admin-body {
            display: flex;
            flex: 1 0 auto;
        }

        .admin-sidebar {
            width: 200px;
            min-width: 200px;
            flex-shrink: 0;
            background: #fff;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .admin-main {
            flex: 1;
            min-width: 0;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            text-decoration: none;
            color: #495057;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: .9rem;
        }
        .menu-link:hover { background-color: #f1f3f5; color: #212529; }
        .menu-link.ativo { background-color: #fff3e8; color: #fd7e14; font-weight: 600; }
        .menu-link.text-danger { color: #dc3545 !important; }
        .menu-link.text-danger:hover { background-color: #f8d7da; }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar bg-white px-3" style="border-bottom:3px solid #fd7e14">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-secondary btn-sm d-md-none me-2" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#menuMobile" aria-controls="menuMobile">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a class="navbar-brand fw-bold mb-0" href="<?= site_url('produtos') ?>" style="color:#fd7e14">
                <i class="fa-solid fa-utensils me-2"></i>Cantina
            </a>
        </div>
        <span class="text-muted small">
            <?= session()->get('user') ? esc(session()->get('user')['email']) : '' ?>
        </span>
    </nav>

    <div class="admin-body">

        <?php $seg = service('uri')->getSegment(1); $seg2 = service('uri')->getSegment(2); ?>

        <aside class="admin-sidebar d-none d-md-flex">
            <p class="text-uppercase text-muted mb-2" style="font-size:.7rem;letter-spacing:.06em">Menu</p>

            <a href="<?= site_url('produtos') ?>" class="menu-link <?= $seg === 'produtos' ? 'ativo' : '' ?>">
                <i class="fa-solid fa-box fa-fw"></i> Produtos
            </a>
            <a href="<?= site_url('estoque') ?>" class="menu-link <?= $seg === 'estoque' ? 'ativo' : '' ?>">
                <i class="fa-solid fa-warehouse fa-fw"></i> Estoque
            </a>
            <a href="<?= site_url('pedidos') ?>" class="menu-link <?= $seg === 'pedidos' ? 'ativo' : '' ?>">
                <i class="fa-solid fa-receipt fa-fw"></i> Pedidos
            </a>
            <?php if ((session()->get('user')['tipo'] ?? null) === 'super_admin'): ?>
                <p class="text-uppercase text-muted mb-2 mt-3" style="font-size:.7rem;letter-spacing:.06em">Administrador</p>
                <a href="<?= site_url('dashboards/consumo') ?>" class="menu-link <?= $seg === 'dashboards' && $seg2 === 'consumo' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-chart-pie fa-fw"></i> Consumo
                </a>
                <a href="<?= site_url('dashboards/vendas') ?>" class="menu-link <?= $seg === 'dashboards' && $seg2 === 'vendas' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-chart-line fa-fw"></i> Vendas
                </a>

                <a href="<?= site_url('totens') ?>" class="menu-link <?= $seg === 'totens' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-tablet-screen-button fa-fw"></i> Totens
                </a>
                <a href="<?= site_url('usuarios') ?>" class="menu-link <?= $seg === 'usuarios' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-users fa-fw"></i> Usuários
                </a>
            <?php endif ?>

            <div class="mt-auto pt-3 border-top">
                <a href="<?= site_url('perfil') ?>" class="menu-link <?= $seg === 'perfil' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-user-gear fa-fw"></i> Meu perfil
                </a>
                <a href="<?= site_url('logout') ?>" class="menu-link text-danger">
                    <i class="fa-solid fa-right-from-bracket fa-fw"></i> Sair
                </a>
            </div>
        </aside>

        <main class="admin-main">
            <?= $this->renderSection('conteudo') ?>
        </main>

    </div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="menuMobile" aria-labelledby="menuMobileLabel">
        <div class="offcanvas-header bg-white" style="border-bottom:3px solid #fd7e14">
            <span class="fw-bold" style="color:#fd7e14">
                <i class="fa-solid fa-utensils me-2"></i>Cantina
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <?php $seg = service('uri')->getSegment(1); $seg2 = service('uri')->getSegment(2); ?>
            <a href="<?= site_url('produtos') ?>" class="menu-link <?= $seg === 'produtos' ? 'ativo' : '' ?>">
                <i class="fa-solid fa-box fa-fw"></i> Produtos
            </a>
            <a href="<?= site_url('estoque') ?>" class="menu-link <?= $seg === 'estoque' ? 'ativo' : '' ?>">
                <i class="fa-solid fa-warehouse fa-fw"></i> Estoque
            </a>
            <a href="<?= site_url('pedidos') ?>" class="menu-link <?= $seg === 'pedidos' ? 'ativo' : '' ?>">
                <i class="fa-solid fa-receipt fa-fw"></i> Pedidos
            </a>
            <?php if ((session()->get('user')['tipo'] ?? null) === 'super_admin'): ?>
                <p class="text-uppercase text-muted mb-2 mt-3" style="font-size:.7rem;letter-spacing:.06em">Administrador</p>
                <a href="<?= site_url('dashboards/consumo') ?>" class="menu-link <?= $seg === 'dashboards' && $seg2 === 'consumo' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-chart-pie fa-fw"></i> Consumo
                </a>
                <a href="<?= site_url('dashboards/vendas') ?>" class="menu-link <?= $seg === 'dashboards' && $seg2 === 'vendas' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-chart-line fa-fw"></i> Vendas
                </a>

                <a href="<?= site_url('totens') ?>" class="menu-link <?= $seg === 'totens' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-tablet-screen-button fa-fw"></i> Totens
                </a>
                <a href="<?= site_url('usuarios') ?>" class="menu-link <?= $seg === 'usuarios' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-users fa-fw"></i> Usuários
                </a>
            <?php endif ?>
            <div class="mt-auto pt-3 border-top">
                <a href="<?= site_url('perfil') ?>" class="menu-link <?= $seg === 'perfil' ? 'ativo' : '' ?>">
                    <i class="fa-solid fa-user-gear fa-fw"></i> Meu perfil
                </a>
                <a href="<?= site_url('logout') ?>" class="menu-link text-danger">
                    <i class="fa-solid fa-right-from-bracket fa-fw"></i> Sair
                </a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
