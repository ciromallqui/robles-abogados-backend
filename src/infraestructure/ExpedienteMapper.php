<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class ExpedienteMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar($solicitud){
		$idArea = $solicitud['idArea'];
		$nroExpediente = $solicitud['nroExpediente'];
		$sql = "SELECT e.id_expediente idExpediente, e.numero nroExpediente, e.titulo, e.id_usuario idUsuario, a.id_area idArea, a.descripcion area, p.nro_documento nroDocumento, concat(p.nombre,' ',p.apellido) nombreCompleto FROM T_EXPEDIENTE e INNER JOIN T_EXPEDIENTE_AREA ea ON ea.id_expediente = e.id_expediente INNER JOIN T_AREA a ON a.id_area = ea.id_area INNER JOIN T_USUARIO u ON u.id_usuario = e.id_usuario INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona WHERE ea.id_area = '$idArea' AND e.numero LIKE '%$nroExpediente%'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}
			// return null;
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function consultar($solicitud){
		$idArea = $solicitud['idArea'];
		$idExpediente = $solicitud['idExpediente'];
		$sql = "SELECT e.id_expediente idExpediente, e.numero nroExpediente, e.titulo, e.id_usuario idUsuario, a.id_area idArea, a.descripcion area, p.nro_documento nroDocumento, p.nombre, p.apellido FROM T_EXPEDIENTE e INNER JOIN T_EXPEDIENTE_AREA ea ON ea.id_expediente = e.id_expediente INNER JOIN T_AREA a ON a.id_area = ea.id_area INNER JOIN T_USUARIO u ON u.id_usuario = e.id_usuario INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona WHERE ea.id_area = '$idArea' AND ea.id_expediente = '$idExpediente'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			return $response->fetch();
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function agregar($solicitud){
		$nroExpediente = $solicitud['nroExpediente'];
		$titulo = $solicitud['titulo'];
		$idUsuario = $solicitud['idUsuario'];
		$sql = "INSERT INTO T_EXPEDIENTE (numero, titulo, id_usuario) VALUES(:nroExpediente, :titulo, :idUsuario)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':nroExpediente', $nroExpediente);
			$response->bindParam(':titulo', $titulo);
			$response->bindParam(':idUsuario', $idUsuario);
			$response->execute();
			$response = null;
			return $config->lastInsertId();
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function agregarExpedienteArea($solicitud){
		$idExpediente = $solicitud['idExpediente'];
		$idArea = $solicitud['idArea'];
		$sql = "INSERT INTO T_EXPEDIENTE_AREA (id_expediente, id_area) VALUES(:idExpediente, :idArea)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':idArea', $idArea);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function listaArea(){
		$sql = "SELECT id_area id, descripcion FROM T_AREA";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}
			// return null;
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}
/*
	public function modificar($solicitud){
		$idPersona = $solicitud['idPersona'];
		$codTipoDocumento = $solicitud['codTipoDocumento'];
		$nroDocumento = $solicitud['nroDocumento'];
		$nombre = $solicitud['nombre'];
		$apellido = $solicitud['apellido'];
		$correo = $solicitud['correo'];
		$nroCelular = $solicitud['nroCelular'];
		$sql = "UPDATE T_PERSONA SET cod_tipo_documento = :codTipoDocumento, nro_documento = :nroDocumento, nombre = :nombre, apellido = :apellido, correo = :correo, nro_celular = :nroCelular WHERE id_persona = :idPersona";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idPersona', $idPersona);
			$response->bindParam(':codTipoDocumento', $codTipoDocumento);
			$response->bindParam(':nroDocumento', $nroDocumento);
			$response->bindParam(':nombre', $nombre);
			$response->bindParam(':apellido', $apellido);
			$response->bindParam(':correo', $correo);
			$response->bindParam(':nroCelular', $nroCelular);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function eliminar($solicitud){
		$idPersona = $solicitud['idPersona'];
		$sql = "DELETE FROM T_PERSONA WHERE id_persona = :idPersona";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idPersona', $idPersona);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}*/
}