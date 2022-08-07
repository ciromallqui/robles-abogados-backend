<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class PerfilMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar(){
		$sql = "SELECT id_perfil id, descripcion FROM T_PERFIL WHERE id_perfil <> 1";
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
}