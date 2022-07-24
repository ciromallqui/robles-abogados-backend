<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class ParametroMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar($solicitud){
		$grupo = $solicitud['grupo'];
		$sql = "SELECT codigo id, descripcion FROM T_PARAMETRO WHERE VISIBLE = '1' AND GRUPO = '$grupo' ORDER BY ORDEN";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}else{
				return json_decode('{"text": "No se encontraron datos para mostrar", "status": 0}');
			}
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}
}