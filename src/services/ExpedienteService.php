<?php
use App\services\JwtTokenSecurity;
use Psr\Container\ContainerInterface;
use App\infraestructure\ExpedienteMapper;

$container->set('container/expediente/inicializar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$consulta = new ExpedienteMapper($containerInterface);
		$data['listaArea'] = $consulta->listaArea();
		if($solicitud['idExpediente'] > 0){
			$data['expediente'] = $consulta->consultar($solicitud);
			$data['partesProcesales'] = $consulta->listaParteProcesal($solicitud);
		}else{
			$data['expediente']  = null;
		}

		$response['data'] = $data;
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/expediente/listar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$expediente = new ExpedienteMapper($containerInterface);
		$response['data'] = $expediente->listar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/expediente/agregar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$expediente = new ExpedienteMapper($containerInterface);
		$solicitud['idExpediente'] = $expediente->agregar($solicitud);
		$expediente->agregarExpedienteArea($solicitud);
		$partesProcesales = $solicitud['partesProcesales'];
		foreach ($partesProcesales as $value) {
			$solicitud['nombreCompleto'] = $value['nombreCompleto'];
			$solicitud['nroDocumento'] = $value['nroDocumento'];
			$solicitud['codTipoParte'] = $value['codTipoParte'];
			$expediente->agregarParteProcesal($solicitud);
		}
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/expediente/modificar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$expediente = new ExpedienteMapper($containerInterface);
		$expediente->modificar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/expediente/eliminar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$expediente = new ExpedienteMapper($containerInterface);
		$expediente->eliminar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/expediente/actualizarArea', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$expediente = new ExpedienteMapper($containerInterface);
		$expediente->actualizarArea($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});