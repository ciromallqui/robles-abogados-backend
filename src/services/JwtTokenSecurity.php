<?php namespace App\services;

use Firebase\JWT\JWT;
use DateTime;

class JwtTokenSecurity{
	public function token($solicitud){
		try{
			$status = 0;
		    $dateNow = new DateTime();
		    $DateFuture = new DateTime("now +8 hours");
		    $payload = [
		    	"iat" => $dateNow->getTimeStamp(), 
		    	"exp" => $DateFuture->getTimeStamp(), 
		    	"sub" => $solicitud['usuario'], 
		    	"perfil" => $solicitud['perfil'],
		    	"idUsuario" => $solicitud['idUsuario']
		    ];
		    $secret = $_ENV['JWT_SECRET'];
		    $token = JWT::encode($payload, $secret, "HS256");
		    $status = 1;
		    $data["status"] = $status;
		    $data["token"] = 'Bearer '.$token;
		    return $data;
		}catch(Exception $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": 0}');
		}
	}
}