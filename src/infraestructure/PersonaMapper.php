<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class PersonaMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar($solicitud){
		$nroDocumento = $solicitud['nroDocumento'];
		$nombre = $solicitud['nombre'];
		$sql = "SELECT id_persona idPersona, (select descripcion from T_PARAMETRO where grupo = 'TIPO_DOCUMENTO' and codigo = P.cod_tipo_documento) tipoDocumento, nro_documento nroDocumento, nombre, apellido, correo, nro_celular nroCelular FROM T_PERSONA P WHERE nro_documento LIKE '%$nroDocumento%' AND (nombre LIKE '%$nombre%' OR apellido LIKE '%$nombre%')";
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
		$idPersona = $solicitud['idPersona'];
		$sql = "SELECT id_persona idPersona, cod_tipo_documento codTipoDocumento, nro_documento nroDocumento, nombre, apellido, correo, nro_celular nroCelular FROM T_PERSONA WHERE id_persona = '$idPersona'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			return $response->fetch();
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function buscarPorDocumento($solicitud){
		$nroDocumento = $solicitud['nroDocumento'];
		$sql = "SELECT p.id_persona idPersona, p.cod_tipo_documento codTipoDocumento, p.nro_documento nroDocumento, p.nombre, p.apellido, p.correo, p.nro_celular nroCelular, u.id_usuario idUsuario, u.codigo_usuario codUsuario FROM T_PERSONA p LEFT JOIN T_USUARIO u ON u.id_persona = p.id_persona WHERE nro_documento = '$nroDocumento'";
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
		$codTipoDocumento = $solicitud['codTipoDocumento'];
		$nroDocumento = $solicitud['nroDocumento'];
		$nombre = $solicitud['nombre'];
		$apellido = $solicitud['apellido'];
		$correo = $solicitud['correo'];
		$nroCelular = $solicitud['nroCelular'];
		$sql = "INSERT INTO T_PERSONA (cod_tipo_documento, nro_documento, nombre, apellido, correo, nro_celular) VALUES(:codTipoDocumento, :nroDocumento, :nombre, :apellido, :correo, :nroCelular)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
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
	}
}