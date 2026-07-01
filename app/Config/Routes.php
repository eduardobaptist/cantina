<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'admin'], function ($routes) {
    $routes->get('produtos', 'ProdutoController::index');
    $routes->get('produtos/novo', 'ProdutoController::novo');
    $routes->post('produtos/salvar', 'ProdutoController::salvar');
    $routes->get('produtos/editar/(:num)', 'ProdutoController::editar/$1');
    $routes->post('produtos/atualizar/(:num)', 'ProdutoController::atualizar/$1');
    $routes->get('produtos/excluir/(:num)', 'ProdutoController::excluir/$1');

    $routes->get('estoque', 'EstoqueController::index');
    $routes->get('estoque/adicionar/(:num)', 'EstoqueController::adicionar/$1');
    $routes->get('estoque/remover/(:num)', 'EstoqueController::remover/$1');
    $routes->post('estoque/salvar', 'EstoqueController::salvar');
    $routes->get('estoque/historico/(:num)', 'EstoqueController::historico/$1');

    $routes->get('pedidos', 'PedidoController::index');

    $routes->get('perfil', 'UsuarioController::perfil');
    $routes->post('perfil', 'UsuarioController::atualizarPerfil');
});

$routes->group('usuarios', ['filter' => 'superadmin'], function ($routes) {
    $routes->get('', 'UsuarioController::index');
    $routes->get('novo', 'UsuarioController::novo');
    $routes->post('salvar', 'UsuarioController::salvar');
    $routes->get('editar/(:num)', 'UsuarioController::editar/$1');
    $routes->post('atualizar/(:num)', 'UsuarioController::atualizar/$1');
    $routes->get('bloquear/(:num)', 'UsuarioController::bloquear/$1');
    $routes->get('desbloquear/(:num)', 'UsuarioController::desbloquear/$1');
});

$routes->group('dashboards', ['filter' => 'superadmin'], function ($routes) {
    $routes->get('consumo', 'DashboardController::consumo');
    $routes->get('vendas', 'DashboardController::vendas');
});

$routes->get('login', 'UsuarioController::login');
$routes->post('login', 'UsuarioController::autenticar');
$routes->get('logout', 'UsuarioController::logout');
$routes->get('401', 'UsuarioController::erro401');

$routes->get('recuperar-senha', 'UsuarioController::esqueciSenha');
$routes->post('recuperar-senha', 'UsuarioController::esqueciSenhaSubmit');

$routes->get('redefinir-senha/(:any)', 'UsuarioController::redefinirSenha/$1');
$routes->post('redefinir-senha', 'UsuarioController::redefinirSenhaSubmit');

// API
$routes->get('api/status', 'Api\ApiController::api_status');
$routes->get('api/produtos', 'Api\ApiController::get_produtos');
$routes->post('api/checkout', 'Api\ApiController::checkout');
$routes->get('api/pedidos', 'Api\ApiController::get_pedidos');
$routes->patch('api/pedidos/(:num)/status', 'Api\ApiController::update_pedido_status/$1');
