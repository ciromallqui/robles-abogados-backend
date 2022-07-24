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
	$group->post('/listar', 'App\controller\PersonaController:listar');
	$group->post('/guardar', 'App\controller\PersonaController:guardar');
	$group->post('/modificar', 'App\controller\PersonaController:modificar');
	$group->post('/eliminar', 'App\controller\PersonaController:eliminar');
});

$app->group('/api/usuario', function(RouteCollectorProxy $group){
	$group->post('/listar', 'App\controller\UsuarioController:listar');
});