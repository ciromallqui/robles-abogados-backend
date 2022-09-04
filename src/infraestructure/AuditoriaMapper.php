<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class AuditoriaMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function agregar($solicitud){
		$descripcion = 		$solicitud['descripcion'];
		$accion = 			$solicitud['accion'];
		$peticion = 		$solicitud['peticion'];
		$cantPeticion = 	$solicitud['cantPeticion'];
		$cantResultado = 	$solicitud['cantResultado'];
		$usuario = 			$solicitud['usuario'];
		$idExpediente =   	$solicitud['idExpediente'];
		$idDocumento =   	$solicitud['idDocumento'];

		$sql = "INSERT INTO T_AUDITORIA (descripcion,accion,peticion,cant_peticion,cant_resultado,id_expediente,id_documento,usuario_crea,fecha_creacion) 
		VALUES (:descripcion, :accion, :peticion, :cantPeticion, :cantResultado, :idExpediente, :idDocumento, :usuario, NOW())";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':descripcion', $descripcion);
			$response->bindParam(':accion', $accion);
			$response->bindParam(':peticion', $peticion);
			$response->bindParam(':cantPeticion', $cantPeticion);
			$response->bindParam(':cantResultado', $cantResultado);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':idDocumento', $idDocumento);
			$response->bindParam(':usuario', $usuario);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}
}