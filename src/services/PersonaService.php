<?php
use App\services\JwtTokenSecurity;
use Psr\Container\ContainerInterface;
use App\infraestructure\PersonaMapper;
use App\infraestructure\ParametroMapper;

$container->set('container/persona/inicializar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$consulta = new ParametroMapper($containerInterface);
		$solicitud['grupo'] = 'TIPO_DOCUMENTO';
		$data['listaTipoDocumento'] = $consulta->listar($solicitud);
		if($solicitud['idPersona'] > 0){
			$persona = new PersonaMapper($containerInterface);
			$data['persona'] = $persona->consultar($solicitud);
		}else{
			$data['persona'] = null;
		}
		$response['data'] = $data;
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/persona/listar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$persona = new PersonaMapper($containerInterface);
		$response['data'] = $persona->listar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/persona/guardar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$persona = new PersonaMapper($containerInterface);
		if($solicitud['idPersona'] > 0){
			$response['data'] = $persona->modificar($solicitud);
		}else{
			$response['data'] = $persona->agregar($solicitud);
		}
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/persona/modificar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$persona = new PersonaMapper($containerInterface);
		$response['data'] = $persona->modificar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/persona/eliminar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$persona = new PersonaMapper($containerInterface);
		$response['data'] = $persona->eliminar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});