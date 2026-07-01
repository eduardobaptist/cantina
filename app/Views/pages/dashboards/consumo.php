<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-chart-pie me-2" style="color:#fd7e14"></i>Painel de consumo</h4>
</div>

<?php
$baseFiltros = [
    'categoria' => $categoria,
    'busca' => $busca,
    'porPagina' => $porPagina,
];
?>

<div class="page-card p-3 mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        <span class="text-muted small fw-semibold me-1">Categorias:</span>
        <form action="<?= site_url('dashboards/consumo') ?>" method="get" class="d-inline">
            <input type="hidden" name="busca" value="<?= esc($busca ?? '') ?>">
            <input type="hidden" name="porPagina" value="<?= esc($porPagina) ?>">
            <input type="hidden" name="periodo" value="<?= esc($periodo) ?>">
            <input type="hidden" name="data_inicio" value="<?= esc($dataInicio ?? '') ?>">
            <input type="hidden" name="data_fim" value="<?= esc($dataFim ?? '') ?>">
            <select name="categoria" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:160px">
                <option value="">Todos</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= esc($cat) ?>" <?= $categoria === $cat ? 'selected' : '' ?>><?= esc(ucfirst($cat)) ?></option>
                <?php endforeach ?>
            </select>
        </form>

        <button type="button" class="btn btn-sm <?= $periodo === 'intervalo' ? 'btn-primary' : 'btn-outline-secondary' ?>"
            data-bs-toggle="collapse" data-bs-target="#intervaloCustom">
            <i class="fa-regular fa-calendar me-1"></i>Intervalo de datas
            <?php if ($periodo === 'intervalo' && $dataInicio && $dataFim): ?>
                <span class="ms-1"><?= esc($dataInicio) ?> a <?= esc($dataFim) ?></span>
            <?php endif ?>
        </button>

        <a href="<?= site_url('dashboards/consumo') . '?' . http_build_query(array_filter(array_merge($baseFiltros, ['periodo' => 'ultimos7']))) ?>"
            class="btn btn-sm <?= $periodo === 'ultimos7' ? 'btn-primary' : 'btn-outline-secondary' ?>">
            Últimos 7 dias
        </a>

        <a href="<?= site_url('dashboards/consumo') . '?' . http_build_query(array_filter(array_merge($baseFiltros, ['periodo' => 'sempre']))) ?>"
            class="btn btn-sm <?= $periodo === 'sempre' ? 'btn-primary' : 'btn-outline-secondary' ?>">
            Desde sempre
        </a>
    </div>

    <div class="collapse <?= $periodo === 'intervalo' ? 'show' : '' ?> mb-3" id="intervaloCustom">
        <form action="<?= site_url('dashboards/consumo') ?>" method="get" class="d-flex flex-wrap align-items-end gap-2">
            <input type="hidden" name="categoria" value="<?= esc($categoria ?? '') ?>">
            <input type="hidden" name="busca" value="<?= esc($busca ?? '') ?>">
            <input type="hidden" name="porPagina" value="<?= esc($porPagina) ?>">
            <input type="hidden" name="periodo" value="intervalo">
            <div>
                <label class="form-label small fw-semibold mb-1">De</label>
                <input type="date" name="data_inicio" class="form-control form-control-sm" value="<?= esc($dataInicio ?? '') ?>">
            </div>
            <div>
                <label class="form-label small fw-semibold mb-1">Até</label>
                <input type="date" name="data_fim" class="form-control form-control-sm" value="<?= esc($dataFim ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
        </form>
    </div>

    <form action="<?= site_url('dashboards/consumo') ?>" method="get" class="row g-2 align-items-center">
        <input type="hidden" name="categoria" value="<?= esc($categoria ?? '') ?>">
        <input type="hidden" name="periodo" value="<?= esc($periodo) ?>">
        <input type="hidden" name="data_inicio" value="<?= esc($dataInicio ?? '') ?>">
        <input type="hidden" name="data_fim" value="<?= esc($dataFim ?? '') ?>">

        <div class="col-auto d-flex align-items-center gap-2">
            <span class="small text-muted">Mostrando</span>
            <select name="porPagina" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <?php foreach ([10, 25, 50, 100] as $opcao): ?>
                    <option value="<?= $opcao ?>" <?= $porPagina === $opcao ? 'selected' : '' ?>><?= $opcao ?></option>
                <?php endforeach ?>
            </select>
            <span class="small text-muted">registros por página.</span>
        </div>

        <div class="col d-flex justify-content-end gap-2">
            <span class="small text-muted align-self-center">Filtrar:</span>
            <input type="text" name="busca" placeholder="Nome do produto..." value="<?= esc($busca ?? '') ?>"
                class="form-control form-control-sm" style="max-width:240px">
            <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        </div>
    </form>
</div>

<?php if (!empty($produtos)): ?>

    <div class="page-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fff8f0">
                    <tr>
                        <th class="ps-3 text-muted fw-semibold small">Produto</th>
                        <th class="text-muted fw-semibold small">Categoria</th>
                        <th class="text-muted fw-semibold small text-end">Estoque atual</th>
                        <th class="pe-3 text-muted fw-semibold small text-end">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-2">
                                    <?php if (!empty($produto['foto'])): ?>
                                        <img src="<?= site_url('uploads/produtos/' . $produto['foto']) ?>"
                                            style="width:36px;height:36px;object-fit:cover;border-radius:6px" alt="">
                                    <?php else: ?>
                                        <div style="width:36px;height:36px;border-radius:6px" class="bg-light"></div>
                                    <?php endif ?>
                                    <span class="fw-semibold"><?= esc($produto['nome']) ?></span>
                                </div>
                            </td>
                            <td><span class="badge rounded-pill text-bg-light text-muted"><?= esc(ucfirst($produto['categoria'])) ?></span></td>
                            <td class="text-end fw-semibold" style="color:<?= (int) $produto['estoque'] <= 0 ? '#dc3545' : '#198754' ?>">
                                <?= esc($produto['estoque']) ?>
                            </td>
                            <td class="pe-3 text-end fw-semibold" style="color:#fd7e14"><?= esc($produto['consumido']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3"><?= $pager->links('default', 'template_pager') ?></div>

<?php else: ?>
    <div class="page-card p-4 text-center text-muted">
        <i class="fa-solid fa-chart-pie fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
        <p class="mb-0">Nenhum produto encontrado para os filtros selecionados.</p>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
