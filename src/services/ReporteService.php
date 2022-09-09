<?php
use App\services\JwtTokenSecurity;
use Psr\Container\ContainerInterface;
use App\infraestructure\ReporteMapper;
use App\infraestructure\ExpedienteMapper;
use App\infraestructure\DocumentoMapper;

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
		$data['documentoBuscado'] = $consulta->documentoBuscado($solicitud);
		$data['documentoEncontrado'] = $consulta->documentoEncontrado($solicitud);
		$data['expedienteDerivado'] = $consulta->expedienteDerivado($solicitud);
		$data['expedienteAtendido'] = $consulta->expedienteAtendido($solicitud);

		$response['data'] = $data;
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});

$container->set('container/reporte/expediente', function(ContainerInterface $containerInterface){
	$solicitud = json_decode(file_get_contents('php://input'), true);
	$response['status'] = 1;
	$response['text'] = 'OK';
	try{
		$expediente = new ExpedienteMapper($containerInterface);
		$documento = new DocumentoMapper($containerInterface);
		$data['expediente'] = $expediente->consultar($solicitud);
		$data['parteProcesal'] = $expediente->listaParteProcesal($solicitud);
		$data['documento'] = $documento->listar($solicitud);
		$response['data'] = $data;
		return $response;
	}catch(Exception $ex){
		return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
	}
});