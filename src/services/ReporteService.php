<?php
use App\services\JwtTokenSecurity;
use Psr\Container\ContainerInterface;
use App\infraestructure\ReporteMapper;

$container->set('container/reporte/inicializar', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$consulta = new ReporteMapper($containerInterface);
		$data['expedientePorArea'] = $consulta->expedientePorArea();
		$data['expedientes'] = $consulta->expedienteAll();
		$data['usuarios'] = $consulta->usuarioAll();
		$data['personas'] = $consulta->personaAll();
		$response['data'] = $data;
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});