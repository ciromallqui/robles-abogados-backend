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
		$areaOrigen = 		$solicitud['areaOrigen'];
		$areaDestino = 		$solicitud['areaDestino'];
		$usuario = 			$solicitud['usuario'];
		$idExpediente =   	$solicitud['idExpediente'];
		$idDocumento =   	$solicitud['idDocumento'];

		$sql = "INSERT INTO T_AUDITORIA (descripcion,accion,peticion,area_origen,area_destino,id_expediente,id_documento,usuario_crea,fecha_creacion) 
		VALUES (:descripcion, :accion, :peticion, :areaOrigen, :areaDestino, :idExpediente, :idDocumento, :usuario, NOW())";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':descripcion', $descripcion);
			$response->bindParam(':accion', $accion);
			$response->bindParam(':peticion', $peticion);
			$response->bindParam(':areaOrigen', $areaOrigen);
			$response->bindParam(':areaDestino', $areaDestino);
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

	public function modificar($solicitud){
		$usuario = 			$solicitud['usuario'];
		$idExpediente =   	$solicitud['idExpediente'];

		$sql = "UPDATE T_AUDITORIA SET usuario_modifica = :usuario, fecha_modificacion = NOW() WHERE id_expediente = :idExpediente AND accion = 'DERIVAR_EXPEDIENTE' AND fecha_modificacion IS NULL";
		$sqle = "UPDATE T_EXPEDIENTE SET cod_estado = '1' WHERE id_expediente = :idExpediente";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':usuario', $usuario);
			$response->execute();
			$response = null;

			$responsee = $config->prepare($sqle);
			$responsee->bindParam(':idExpediente', $idExpediente);
			$responsee->execute();
			$responsee = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}
}