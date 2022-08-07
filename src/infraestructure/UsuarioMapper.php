<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class UsuarioMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar($solicitud){
		$sql = "SELECT u.id_usuario idUsuario,u.codigo_usuario codUsuario,u.clave,p.id_persona idPersona,p.nro_documento nroDocumento,p.nombre,p.apellido,p.correo,p.nro_celular nroCelular,r.id_perfil idPerfil,r.descripcion perfil,up.id_usuario_perfil idUsuarioPerfil FROM T_USUARIO u INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona INNER JOIN T_USUARIO_PERFIL up ON up.id_usuario = u.id_usuario INNER JOIN T_PERFIL r ON r.id_perfil = up.id_perfil";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function consultar($solicitud){
		$idUsuario = $solicitud['idUsuario'];
		$idPerfil = $solicitud['idPerfil'];
		$sql = "SELECT u.id_usuario idUsuario,u.codigo_usuario codUsuario,u.clave,p.id_persona idPersona,p.nro_documento nroDocumento,p.nombre,p.apellido,p.correo,p.nro_celular nroCelular,r.id_perfil idPerfil,r.descripcion perfil,up.id_usuario_perfil idUsuarioPerfil FROM T_USUARIO u INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona INNER JOIN T_USUARIO_PERFIL up ON up.id_usuario = u.id_usuario INNER JOIN T_PERFIL r ON r.id_perfil = up.id_perfil WHERE u.id_usuario = '$idUsuario' AND r.id_perfil = '$idPerfil'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function agregar($solicitud){
		$codUsuario = $solicitud['codUsuario'];
		$clave = $solicitud['clave'];
		$idPersona = $solicitud['idPersona'];
		$sql = "INSERT INTO T_USUARIO (codigo_usuario, clave, id_persona) VALUES (:codUsuario, :clave, :idPersona)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':codUsuario', $codUsuario);
			$response->bindParam(':clave', $clave);
			$response->bindParam(':idPersona', $idPersona);
			$response->execute();
			$response = null;
			return $config->lastInsertId();
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function agregarUsuarioPerfil($solicitud){
		$idUsuario = $solicitud['idUsuario'];
		$idPerfil = $solicitud['idPerfil'];
		$sql = "INSERT INTO T_USUARIO_PERFIL (id_usuario, id_perfil) VALUES (:idUsuario, :idPerfil)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idUsuario', $idUsuario);
			$response->bindParam(':idPerfil', $idPerfil);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function modificarUsuarioPerfil($solicitud){
		$idUsuarioPerfil = $solicitud['idUsuarioPerfil'];
		$idPerfil = $solicitud['idPerfil'];
		$sql = "UPDATE T_USUARIO_PERFIL SET id_perfil = :idPerfil WHERE id_usuario_perfil = :idUsuarioPerfil";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idUsuarioPerfil', $idUsuarioPerfil);
			$response->bindParam(':idPerfil', $idPerfil);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}
}