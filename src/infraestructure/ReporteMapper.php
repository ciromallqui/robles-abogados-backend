<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class ReporteMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function expedientePorArea(){
		$sql = "SELECT COUNT(e.id_expediente) cantidadExpediente, a.descripcion area 
		FROM T_EXPEDIENTE e 
		INNER JOIN T_EXPEDIENTE_AREA ea ON ea.id_expediente = e.id_expediente 
		INNER JOIN T_AREA a ON a.id_area = ea.id_area
		WHERE e.fecha_eliminacion is null 
		GROUP BY a.descripcion";
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

	public function expedienteAll(){
		$sql = "SELECT COUNT(e.id_expediente) cantidad
		FROM T_EXPEDIENTE e 
		WHERE e.fecha_eliminacion is null";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function usuarioAll(){
		$sql = "SELECT COUNT(id_usuario) cantidad FROM T_USUARIO";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function personaAll(){
		$sql = "SELECT COUNT(u.id_usuario) cantidad FROM T_USUARIO u INNER JOIN T_USUARIO_PERFIL up ON up.id_usuario = u.id_usuario WHERE id_perfil = 3";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	//Primer indicador
	public function expedienteDerivado($solicitud){
		$fecha = $solicitud['fecha'];
		$sql = "SELECT COUNT(id_auditoria) cantidad, max(date_format('$fecha', '%d/%m/%Y')) fechaBusqueda FROM T_AUDITORIA WHERE accion = 'DERIVAR_EXPEDIENTE' AND fecha_creacion = '$fecha'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function expedienteAtendido($solicitud){
		$fecha = $solicitud['fecha'];
		$sql = "SELECT COUNT(id_auditoria) cantidad FROM T_AUDITORIA WHERE accion = 'DERIVAR_EXPEDIENTE' AND fecha_creacion = '$fecha' AND fecha_modificacion = '$fecha'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	//Segundo indicador
	public function documentoBuscado($solicitud){
		$fecha = $solicitud['fecha'];
		$sql = "SELECT COUNT(id_auditoria) cantidad FROM T_AUDITORIA WHERE accion = 'BUSCAR_DOCUMENTO' AND fecha_creacion = '$fecha'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function documentoEncontrado($solicitud){
		$fecha = $solicitud['fecha'];
		$sql = "SELECT COUNT(id_auditoria) cantidad, max(date_format('$fecha', '%d/%m/%Y')) fechaBusqueda FROM T_AUDITORIA WHERE accion = 'BUSCAR_DOCUMENTO' AND id_documento > 0 AND fecha_creacion = '$fecha'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetch();
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}
}