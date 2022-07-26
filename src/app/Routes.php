<?php

use Slim\Routing\RouteCollectorProxy;

$app->group('/api/sesion', function(RouteCollectorProxy $group){
	$group->post('/iniciar', 'App\controller\SesionController:iniciar');
});

$app->group('/api/parametro', function(RouteCollectorProxy $group){
	$group->post('/listar', 'App\controller\ParametroController:listar');
	$group->post('/lista', 'App\controller\ParametroController:lista');
});

$app->group('/api/persona', function(RouteCollectorProxy $group){
	$group->post('/inicializar', 'App\controller\PersonaController:inicializar');
	$group->post('/consultar', 'App\controller\PersonaController:consultar');
	$group->post('/buscarPorDocumento', 'App\controller\PersonaController:buscarPorDocumento');
	$group->post('/listar', 'App\controller\PersonaController:listar');
	$group->post('/guardar', 'App\controller\PersonaController:guardar');
	$group->post('/modificar', 'App\controller\PersonaController:modificar');
	$group->post('/eliminar', 'App\controller\PersonaController:eliminar');
});

$app->group('/api/usuario', function(RouteCollectorProxy $group){
	$group->post('/listar', 'App\controller\UsuarioController:listar');
	$group->post('/inicializar', 'App\controller\UsuarioController:inicializar');
	$group->post('/agregar', 'App\controller\UsuarioController:agregar');
	$group->post('/modificar', 'App\controller\UsuarioController:modificar');
});

$app->group('/api/expediente', function(RouteCollectorProxy $group){
	$group->post('/listar', 'App\controller\ExpedienteController:listar');
	$group->post('/inicializar', 'App\controller\ExpedienteController:inicializar');
	$group->post('/agregar', 'App\controller\ExpedienteController:agregar');
	$group->post('/modificar', 'App\controller\ExpedienteController:modificar');
	$group->post('/actualizarArea', 'App\controller\ExpedienteController:actualizarArea');
	$group->post('/actualizarEstado', 'App\controller\ExpedienteController:actualizarEstado');
	$group->post('/eliminar', 'App\controller\ExpedienteController:eliminar');
	$group->post('/listarProvincia', 'App\controller\ExpedienteController:listarProvincia');
	$group->post('/listarDistrito', 'App\controller\ExpedienteController:listarDistrito');
});

$app->group('/api/documento', function(RouteCollectorProxy $group){
	$group->post('/agregar', 'App\controller\DocumentoController:agregar');
	$group->post('/listar', 'App\controller\DocumentoController:listar');
});

$app->group('/api/reporte', function(RouteCollectorProxy $group){
	$group->post('/inicializar', 'App\controller\ReporteController:inicializar');
	$group->post('/expediente', 'App\controller\ReporteController:expediente');
});

$app->group('/api/auditoria', function(RouteCollectorProxy $group){
	$group->post('/agregar', 'App\controller\AuditoriaController:agregar');
	$group->post('/modificar', 'App\controller\AuditoriaController:modificar');
});