<?php namespace App\controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\controller\BaseController;

class PersonaController extends BaseController{

	public function inicializar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/inicializar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function consultar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/consultar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function buscarPorDocumento(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/buscarPorDocumento');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function listar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/listar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function guardar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/guardar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function modificar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/modificar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function eliminar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/persona/eliminar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}
}