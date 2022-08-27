<?php namespace App\controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\controller\BaseController;

class ExpedienteController extends BaseController{

	public function inicializar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/expediente/inicializar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function listar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/expediente/listar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function agregar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/expediente/agregar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function modificar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/expediente/modificar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function eliminar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/expediente/eliminar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function actualizarArea(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/expediente/actualizarArea');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}
}