<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class UsuarioMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar($solicitud){
		$sql = "SELECT u.id_usuario idUsuario,u.codigo_usuario codUsuario,u.clave,p.id_persona idPersona,p.nro_documento nroDocumento,p.nombre,p.apellido,p.correo,p.nro_celular nroCelular,r.id_perfil idPerfil,r.descripcion perfil FROM T_USUARIO u INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona INNER JOIN T_USUARIO_PERFIL up ON up.id_usuario = u.id_usuario INNER JOIN T_PERFIL r ON r.id_perfil = up.id_perfil";
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