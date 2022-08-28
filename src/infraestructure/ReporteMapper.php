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
		$sql = "SELECT COUNT(id_persona) cantidad FROM T_PERSONA";
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