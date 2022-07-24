<?php
use Psr\Container\ContainerInterface;
use App\services\JwtTokenSecurity;
use App\infraestructure\SesionMapper;

$container->set('container/sesion/iniciar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = null;
	try{
		$jwt = new JwtTokenSecurity();
		$sesion = new SesionMapper($containerInterface);
		$login = $sesion->login($solicitud);
		if(count($login) > 0){
			$solicitud['idUsuario'] = (int)$login[0]->id_usuario;
			$usuario['usuario'] = $sesion->usuario($solicitud);
			$roles = $sesion->perfil($solicitud);

			$array = array();
			foreach ($roles as $value) {
				$array[] = $value->descripcion;
			}

			$solicitud['perfil'] = $array;
			$token = $jwt->token($solicitud);
			$usuario['token'] = $token['token'];
			$response['data'] = $usuario;
			return $response;
		}else{
			return json_decode('{"text": "No se encontró al usuario con los credenciales ingresados.", "status": 0}');
		}
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});