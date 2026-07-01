<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-chart-line me-2" style="color:#fd7e14"></i>Painel de vendas</h4>
</div>

<?php
$baseFiltros = [
    'busca' => $busca,
    'porPagina' => $porPagina,
];
?>

<div class="page-card p-3 mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        <button type="button" class="btn btn-sm <?= $periodo === 'intervalo' ? 'btn-primary' : 'btn-outline-secondary' ?>"
            data-bs-toggle="collapse" data-bs-target="#intervaloCustom">
            <i class="fa-regular fa-calendar me-1"></i>Intervalo de datas
            <?php if ($periodo === 'intervalo' && $dataInicio && $dataFim): ?>
                <span class="ms-1"><?= esc(date('d/m/Y', strtotime($dataInicio))) ?> a <?= esc(date('d/m/Y', strtotime($dataFim))) ?></span>
            <?php endif ?>
        </button>

        <a href="<?= site_url('dashboards/vendas') . '?' . http_build_query(array_filter(array_merge($baseFiltros, ['periodo' => 'ultimos7']))) ?>"
            class="btn btn-sm <?= $periodo === 'ultimos7' ? 'btn-primary' : 'btn-outline-secondary' ?>">
            Últimos 7 dias
        </a>

        <a href="<?= site_url('dashboards/vendas') . '?' . http_build_query(array_filter(array_merge($baseFiltros, ['periodo' => 'sempre']))) ?>"
            class="btn btn-sm <?= $periodo === 'sempre' ? 'btn-primary' : 'btn-outline-secondary' ?>">
            Desde sempre
        </a>
    </div>

    <div class="collapse <?= $periodo === 'intervalo' ? 'show' : '' ?>" id="intervaloCustom">
        <form action="<?= site_url('dashboards/vendas') ?>" method="get" class="d-flex flex-wrap align-items-end gap-2">
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
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="page-card p-3 mb-3">
            <form action="<?= site_url('dashboards/vendas') ?>" method="get" class="row g-2 align-items-center">
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
                    <span class="small text-muted">por página</span>
                </div>

                <div class="col d-flex justify-content-end gap-2">
                    <input type="text" name="busca" placeholder="Filtrar..." value="<?= esc($busca ?? '') ?>"
                        class="form-control form-control-sm" style="max-width:160px">
                    <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                </div>
            </form>
        </div>

        <?php if (!empty($vendas)): ?>
            <div class="page-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#fff8f0">
                            <tr>
                                <th class="ps-3 text-muted fw-semibold small">Data</th>
                                <th class="pe-3 text-muted fw-semibold small text-end">Valor total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendas as $venda): ?>
                                <tr>
                                    <td class="ps-3"><?= esc(date('d/m/Y', strtotime($venda['data']))) ?></td>
                                    <td class="pe-3 text-end fw-semibold" style="color:#fd7e14">
                                        R$ <?= number_format((float) $venda['valor_total'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3"><?= $pager->links('default', 'template_pager') ?></div>
        <?php else: ?>
            <div class="page-card p-4 text-center text-muted">
                <i class="fa-solid fa-receipt fa-3x mb-3" style="color:#fd7e14;opacity:.4"></i>
                <p class="mb-0">Nenhuma venda encontrada para os filtros selecionados.</p>
            </div>
        <?php endif ?>
    </div>

    <div class="col-lg-7">
        <div class="page-card p-3" style="height:100%">
            <h6 class="fw-bold mb-3">Gráfico de vendas dos últimos <?= count($labels) ?> <?= count($labels) === 1 ? 'dia' : 'dias' ?></h6>
            <?php if (!empty($labels)): ?>
                <canvas id="graficoVendas" height="160"></canvas>
            <?php else: ?>
                <p class="text-muted mb-0">Sem dados suficientes para montar o gráfico.</p>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (!empty($labels)): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        new Chart(document.getElementById('graficoVendas'), {
            type: 'line',
            data: {
                labels: <?= json_encode(array_map(fn($d) => date('d/m/Y', strtotime($d)), $labels)) ?>,
                datasets: [{
                    label: 'Valor vendido (R$)',
                    data: <?= json_encode($valores) ?>,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253,126,20,.15)',
                    fill: true,
                    tension: 0.2,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
            },
        });
    </script>
<?php endif ?>
<?= $this->endSection() ?>
