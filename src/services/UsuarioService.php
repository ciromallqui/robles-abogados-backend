<?php
use App\services\JwtTokenSecurity;
use Psr\Container\ContainerInterface;
use App\infraestructure\PerfilMapper;
use App\infraestructure\UsuarioMapper;

$container->set('container/usuario/inicializar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$consulta = new PerfilMapper($containerInterface);
		$data['listaPerfil'] = $consulta->listar();
		if($solicitud['idUsuario'] > 0){
			$usuario = new UsuarioMapper($containerInterface);
			$data['usuario'] = $usuario->consultar($solicitud);
		}else{
			$data['usuario']  = null;
		}
		$response['data'] = $data;
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/usuario/listar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$usuario = new UsuarioMapper($containerInterface);
		$response['data'] = $usuario->listar($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/usuario/agregar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$usuario = new UsuarioMapper($containerInterface);
		$solicitud['idUsuario'] = $usuario->agregar($solicitud);
		$usuario->agregarUsuarioPerfil($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/usuario/modificar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$usuario = new UsuarioMapper($containerInterface);
		$usuario->modificarUsuarioPerfil($solicitud);
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});