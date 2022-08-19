<?php namespace App\controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\controller\BaseController;

class DocumentoController extends BaseController{

	public function agregar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/documento/agregar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}

	public function listar(Request $request, Response $response, $args){
		try{
			$config = $this->container->get('container/documento/listar');
			$response->getBody()->write(json_encode($config));
			return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		}catch(Exception $ex){
			echo $ex.getMessage();
		}
	}
}