<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class DocumentoMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function agregar($solicitud){
		$asunto = 			$solicitud['asunto'];
		$descripcion = 		$solicitud['descripcion'];
		$nombre = 			$solicitud['nombre'];
		$archivo = 			$solicitud['archivo'];
		$codTipo = 			$solicitud['codTipo'];
		$usuario = 			$solicitud['usuario'];
		$fechaCreacion = 	$solicitud['fechaCreacion'];
		$idExpediente =   	$solicitud['idExpediente'];

		$sql = "INSERT INTO T_DOCUMENTO (asunto,descripcion,nombre,archivo,cod_tipo,id_expediente,usuario_crea,fecha_creacion) 
		VALUES (:asunto, :descripcion, :nombre, :archivo, :codTipo, :idExpediente, :usuario, :fechaCreacion)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':asunto', $asunto);
			$response->bindParam(':descripcion', $descripcion);
			$response->bindParam(':nombre', $nombre);
			$response->bindParam(':archivo', $archivo);
			$response->bindParam(':codTipo', $codTipo);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':usuario', $usuario);
			$response->bindParam(':fechaCreacion', $fechaCreacion);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function listar($solicitud){
		$idExpediente = $solicitud['idExpediente'];
		$sql = "SELECT d.id_documento idDocumento,d.asunto,d.descripcion,d.nombre,d.archivo,d.cod_tipo codTipo,e.id_expediente idExpediente,date_format(d.fecha_creacion, '%d/%m/%Y') fechaCreacion
		FROM T_DOCUMENTO d 
		INNER JOIN _EXPEDIENTE e  ON e.id_expediente = d.id_expediente 
		WHERE e.id_expediente = '$idExpediente'";

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