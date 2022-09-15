<?php namespace App\services;
use Psr\Container\ContainerInterface;
use App\infraestructure\ParametroMapper;

$container->set('container/parametro/listar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	try{
		$consulta = new ParametroMapper($containerInterface);
		$solicitud['grupo'] = 'TIPO_DOCUMENTO';
		return $consulta->listar($solicitud);
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/parametro/lista', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	try{
		$consulta = new ParametroMapper($containerInterface);
		$solicitud['grupo'] = 'TIPO_DOCUMENTO';
		return $consulta->lista($solicitud);
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});