<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class UbigeoMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listaDepartamento(){
		$sql = "SELECT DISTINCT cod_departamento id, departamento descripcion FROM T_UBIGEO";
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

	public function listaProvincia($solicitud){
		$codDepartamento = $solicitud['codDepartamento'];
		$sql = "SELECT DISTINCT cod_provincia id, provincia descripcion FROM T_UBIGEO 
				WHERE cod_departamento = '$codDepartamento'";
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

	public function listaDistrito($solicitud){
		$codProvincia = $solicitud['codProvincia'];
		$sql = "SELECT DISTINCT cod_distrito id, distrito descripcion FROM T_UBIGEO 
				WHERE cod_provincia = '$codProvincia'";
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

	public function obtenerUbigeo($solicitud){
		$codDepartamento = 	$solicitud['codDepartamento'];
		$codProvincia = 	$solicitud['codProvincia'];
		$codDistrito = 		$solicitud['codDistrito'];
		$sql = "SELECT departamento, provincia, distrito FROM T_UBIGEO 
				WHERE cod_departamento = '$codDepartamento' AND cod_provincia = '$codProvincia' AND cod_distrito = '$codDistrito'";
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