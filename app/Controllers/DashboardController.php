<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    private function resolverPeriodo(string $periodo, ?string $dataInicio, ?string $dataFim): array
    {
        if ($periodo === 'ultimos7') {
            return [date('Y-m-d 00:00:00', strtotime('-6 days')), date('Y-m-d 23:59:59')];
        }

        if (
            $periodo === 'intervalo'
            && preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $dataInicio)
            && preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $dataFim)
        ) {
            return [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59'];
        }

        return [null, null];
    }

    public function consumo(): string
    {
        $categoria = $this->request->getGet('categoria');
        $periodo = $this->request->getGet('periodo') ?? 'sempre';
        $dataInicio = $this->request->getGet('data_inicio');
        $dataFim = $this->request->getGet('data_fim');
        $busca = $this->request->getGet('busca');
        $porPagina = (int) ($this->request->getGet('porPagina') ?? 10);
        $porPagina = in_array($porPagina, [10, 25, 50, 100], true) ? $porPagina : 10;
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));

        [$inicio, $fim] = $this->resolverPeriodo($periodo, $dataInicio, $dataFim);

        $db = \Config\Database::connect();

        $consumidoExpr = "COALESCE((SELECT SUM(e.quantidade) FROM estoques e"
            . " WHERE e.produto_id = produtos.id AND e.tipo = 'saida'"
            . ($inicio ? " AND e.created_at BETWEEN {$db->escape($inicio)} AND {$db->escape($fim)}" : '')
            . "), 0) AS consumido";

        $builder = $db->table('produtos')->select("produtos.*, $consumidoExpr", false);

        if ($categoria) {
            $builder->where('categoria', $categoria);
        }
        if ($busca) {
            $builder->like('nome', $busca);
        }

        $total = (clone $builder)->countAllResults();

        $produtos = $builder
            ->orderBy('nome', 'asc')
            ->limit($porPagina, ($page - 1) * $porPagina)
            ->get()
            ->getResultArray();

        $categorias = array_column(
            $db->table('produtos')->distinct()->select('categoria')->orderBy('categoria', 'asc')->get()->getResultArray(),
            'categoria'
        );

        $pager = service('pager');
        $pager->store('default', $page, $porPagina, $total);

        return view('pages/dashboards/consumo', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'pager' => $pager,
            'categoria' => $categoria,
            'periodo' => $periodo,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'busca' => $busca,
            'porPagina' => $porPagina,
        ]);
    }

    public function vendas(): string
    {
        $periodo = $this->request->getGet('periodo') ?? 'ultimos7';
        $dataInicio = $this->request->getGet('data_inicio');
        $dataFim = $this->request->getGet('data_fim');
        $busca = $this->request->getGet('busca');
        $porPagina = (int) ($this->request->getGet('porPagina') ?? 25);
        $porPagina = in_array($porPagina, [10, 25, 50, 100], true) ? $porPagina : 25;
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));

        [$inicio, $fim] = $this->resolverPeriodo($periodo, $dataInicio, $dataFim);

        $db = \Config\Database::connect();

        $builder = $db->table('pedidos pe')
            ->select('DATE(pe.created_at) AS data, SUM(pp.quantidade * pp.preco_unitario) AS valor_total')
            ->join('pedido_produtos pp', 'pp.id_pedido = pe.id AND pp.deleted_at IS NULL')
            ->where('pe.deleted_at IS NULL')
            ->where('pe.status', 'pronto')
            ->groupBy('DATE(pe.created_at)')
            ->orderBy('data', 'DESC');

        if ($inicio) {
            $builder->where('pe.created_at >=', $inicio)->where('pe.created_at <=', $fim);
        }

        // Volume de dias com vendas numa cantina escolar é pequeno: busca-se tudo de uma
        // vez e pagina-se/filtra-se em PHP, evitando lidar com COUNT sobre GROUP BY.
        $linhas = $builder->get()->getResultArray();

        if ($busca) {
            $linhas = array_values(array_filter(
                $linhas,
                fn($linha) => stripos($linha['data'], $busca) !== false
            ));
        }

        $total = count($linhas);
        $offset = ($page - 1) * $porPagina;
        $linhasPagina = array_slice($linhas, $offset, $porPagina);

        $pontosGrafico = array_reverse(array_slice($linhas, 0, 30));
        $labels = array_column($pontosGrafico, 'data');
        $valores = array_map(fn($v) => (float) $v, array_column($pontosGrafico, 'valor_total'));

        $pager = service('pager');
        $pager->store('default', $page, $porPagina, $total);

        return view('pages/dashboards/vendas', [
            'vendas' => $linhasPagina,
            'pager' => $pager,
            'periodo' => $periodo,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'busca' => $busca,
            'porPagina' => $porPagina,
            'labels' => $labels,
            'valores' => $valores,
        ]);
    }
}
