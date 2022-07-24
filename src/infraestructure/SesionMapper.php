<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class SesionMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function login($solicitud){
		$usuario = $solicitud['usuario'];
		$clave = $solicitud['clave'];
		$sql = "SELECT * FROM T_USUARIO WHERE codigo_usuario = '$usuario' AND clave = '$clave'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			return $response->fetchAll();
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function usuario($solicitud){
		$idUsuario = $solicitud['idUsuario'];
		$sql = "SELECT id_usuario idUsuario,codigo_usuario usuario, nro_documento nroDocumento,concat(apellido,' ',nombre) nombreCompleto,correo FROM T_USUARIO u INNER JOIN T_PERSONA p ON u.id_persona = p.id_persona WHERE id_usuario = '$idUsuario'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}else{
				return json_decode('{"text": "No se encontraron datos para mostrar", "status": 0}');
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function perfil($solicitud){
		$idUsuario = $solicitud['idUsuario'];
		$sql = "SELECT p.descripcion FROM T_USUARIO_PERFIL up INNER JOIN T_USUARIO u ON u.id_usuario = up.id_usuario INNER JOIN T_PERFIL p ON p.id_perfil = up.id_perfil WHERE u.id_usuario = '$idUsuario'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}else{
				return json_decode('{"text": "No se encontraron datos.", "status": 0}');
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}
}