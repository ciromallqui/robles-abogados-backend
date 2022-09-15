<?php namespace App\infraestructure;

use Psr\Container\ContainerInterface;

class ExpedienteMapper{
	private $container;
	public function __construct(ContainerInterface $containerInterface){
		$this->container = $containerInterface;
	}

	public function listar($solicitud){
		$idArea = $solicitud['idArea'];
		$codEstado = $solicitud['codEstado'];
		$nroExpediente = $solicitud['nroExpediente'];
		$sql = "SELECT e.id_expediente idExpediente, e.correlativo correlativo,e.anio,e.extension,e.nro_expediente nroExpediente,e.referencia,date_format(e.fecha_inicio, '%d/%m/%Y') fechaInicio,e.delito_principal delitoPrincipal,e.cod_procedencia codProcedencia,e.cod_motivo codMotivo,e.proceso,e.organo_jurisdiccional organoJurisdiccional,e.sumilla,e.ubicacion,e.parte_procesal parteProcesal,e.codigo,e.expediente_origen expedienteOrigen,e.juez_ponente juezPonente,e.especialista_legal especialistaLegal,e.abogado_responsable abogadoResponsable,e.fiscalia,e.fiscal,e.comisaria,e.nro_carpeta nroCarpeta,e.nro_denuncia nroDenuncia,e.ubicacion_fisica ubicacionFisica,e.cod_departamento codDepartamento,e.cod_provincia codProvincia,e.cod_distrito codDistrito,e.anexo_caserio anexoCaserio,date_format(e.fecha, '%d/%m/%Y') fecha,e.usuario_crea usuarioCrea,date_format(e.fecha_creacion, '%d/%m/%Y') fechaCreacion,u.id_usuario idUsuario, a.id_area idArea, a.descripcion area, p.nro_documento nroDocumento, concat(p.nombre,' ',p.apellido) nombreCompleto, TIMESTAMPDIFF(DAY, e.fecha_inicio, now()) dias, e.cod_estado codEstado
		FROM T_EXPEDIENTE e 
		INNER JOIN T_EXPEDIENTE_AREA ea ON ea.id_expediente = e.id_expediente 
		INNER JOIN T_AREA a ON a.id_area = ea.id_area 
		INNER JOIN T_USUARIO u ON u.id_usuario = e.id_usuario 
		INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona 
		WHERE e.fecha_eliminacion is null AND (ea.id_area = '$idArea' OR ea.id_area = 2) AND e.nro_expediente LIKE '%$nroExpediente%' AND e.cod_estado LIKE '%$codEstado%'";

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

	public function consultar($solicitud){
		$idArea = $solicitud['idArea'];
		$idExpediente = $solicitud['idExpediente'];
		$sql = "SELECT e.id_expediente idExpediente, e.correlativo correlativo,e.anio,e.extension,e.nro_expediente nroExpediente,e.referencia,date_format(e.fecha_inicio, '%d/%m/%Y') fechaInicio,e.delito_principal delitoPrincipal,e.cod_procedencia codProcedencia,e.cod_motivo codMotivo,e.proceso,e.organo_jurisdiccional organoJurisdiccional,e.sumilla,e.ubicacion,e.parte_procesal parteProcesal,e.codigo,e.expediente_origen expedienteOrigen,e.juez_ponente juezPonente,e.especialista_legal especialistaLegal,e.abogado_responsable abogadoResponsable,e.fiscalia,e.fiscal,e.comisaria,e.nro_carpeta nroCarpeta,e.nro_denuncia nroDenuncia,e.ubicacion_fisica ubicacionFisica,e.cod_departamento codDepartamento,e.cod_provincia codProvincia,e.cod_distrito codDistrito,e.anexo_caserio anexoCaserio,date_format(e.fecha, '%d/%m/%Y') fecha,e.usuario_crea usuarioCrea,date_format(e.fecha_creacion, '%d/%m/%Y') fechaCreacion,u.id_usuario idUsuario, a.id_area idArea, a.descripcion area, p.nro_documento nroDocumento, p.nombre, p.apellido, (select distrito from T_UBIGEO where cod_distrito = e.cod_distrito) distrito, e.cod_estado codEstado 
		FROM T_EXPEDIENTE e 
		INNER JOIN T_EXPEDIENTE_AREA ea ON ea.id_expediente = e.id_expediente 
		INNER JOIN T_AREA a ON a.id_area = ea.id_area 
		INNER JOIN T_USUARIO u ON u.id_usuario = e.id_usuario 
		INNER JOIN T_PERSONA p ON p.id_persona = u.id_persona 
		WHERE ea.id_expediente = '$idExpediente'";

		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			return $response->fetch();
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}

	public function agregar($solicitud){
		$correlativo =		$solicitud['correlativo'];
		$anio = 			$solicitud['anio'];
		$extension = 		$solicitud['extension'];
		$nroExpediente = 	$solicitud['nroExpediente'];
		$referencia = 		$solicitud['referencia'];
		$fechaInicio = 		date("Y-m-d", strtotime($solicitud['fechaInicio']));
		$delitoPrincipal = 	$solicitud['delitoPrincipal'];
		$codProcedencia = 	$solicitud['codProcedencia'];
		$codMotivo = 		$solicitud['codMotivo'];
		$proceso = 			$solicitud['proceso'];
		$organoJurisdiccional = $solicitud['organoJurisdiccional'];
		$sumilla = 			$solicitud['sumilla'];
		$ubicacion = 		$solicitud['ubicacion'];
		$parteProcesal = 	$solicitud['parteProcesal'];
		$codigo = 			$solicitud['codigo'];
		$expedienteOrigen = $solicitud['expedienteOrigen'];
		$juezPonente = 		$solicitud['juezPonente'];
		$especialistaLegal = $solicitud['especialistaLegal'];
		$abogadoResponsable = $solicitud['abogadoResponsable'];
		$fiscalia = 		$solicitud['fiscalia'];
		$fiscal = 			$solicitud['fiscal'];
		$comisaria = 		$solicitud['comisaria'];
		$nroCarpeta = 		$solicitud['nroCarpeta'];
		$nroDenuncia = 		$solicitud['nroDenuncia'];
		$ubicacionFisica = 	$solicitud['ubicacionFisica'];
		$codDepartamento = 	$solicitud['codDepartamento'];
		$codProvincia = 	$solicitud['codProvincia'];
		$codDistrito = 		$solicitud['codDistrito'];
		$anexoCaserio = 	$solicitud['anexoCaserio'];
		$fecha = 			date("Y-m-d", strtotime($solicitud['fecha']));
		$usuario = 			$solicitud['usuario'];
		$idUsuario = 		$solicitud['idUsuario'];

		$sql = "INSERT INTO T_EXPEDIENTE (correlativo,anio,extension,nro_expediente,referencia,fecha_inicio,delito_principal,cod_procedencia,cod_motivo,proceso,organo_jurisdiccional,sumilla,ubicacion,parte_procesal,codigo,expediente_origen,juez_ponente,especialista_legal,abogado_responsable,fiscalia,fiscal,comisaria,nro_carpeta,nro_denuncia,ubicacion_fisica,cod_departamento,cod_provincia,cod_distrito,anexo_caserio,fecha,usuario_crea,fecha_creacion,id_usuario) 
		VALUES(:correlativo, :anio, :extension, :nroExpediente, :referencia, :fechaInicio, :delitoPrincipal, :codProcedencia, :codMotivo, :proceso, :organoJurisdiccional, :sumilla, :ubicacion, :parteProcesal, :codigo, :expedienteOrigen, :juezPonente, :especialistaLegal, :abogadoResponsable, :fiscalia, :fiscal, :comisaria, :nroCarpeta, :nroDenuncia, :ubicacionFisica, :codDepartamento, :codProvincia, :codDistrito, :anexoCaserio, :fecha, :usuario, now(), :idUsuario)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':correlativo', $correlativo);
			$response->bindParam(':anio', $anio);
			$response->bindParam(':extension', $extension);
			$response->bindParam(':nroExpediente', $nroExpediente);
			$response->bindParam(':referencia', $referencia);
			$response->bindParam(':fechaInicio', $fechaInicio);
			$response->bindParam(':delitoPrincipal', $delitoPrincipal);
			$response->bindParam(':codProcedencia', $codProcedencia);
			$response->bindParam(':codMotivo', $codMotivo);
			$response->bindParam(':proceso', $proceso);
			$response->bindParam(':organoJurisdiccional', $organoJurisdiccional);
			$response->bindParam(':sumilla', $sumilla);
			$response->bindParam(':ubicacion', $ubicacion);
			$response->bindParam(':parteProcesal', $parteProcesal);
			$response->bindParam(':codigo', $codigo);
			$response->bindParam(':expedienteOrigen', $expedienteOrigen);
			$response->bindParam(':juezPonente', $juezPonente);
			$response->bindParam(':especialistaLegal', $especialistaLegal);
			$response->bindParam(':abogadoResponsable', $abogadoResponsable);
			$response->bindParam(':fiscalia', $fiscalia);
			$response->bindParam(':fiscal', $fiscal);
			$response->bindParam(':comisaria', $comisaria);
			$response->bindParam(':nroCarpeta', $nroCarpeta);
			$response->bindParam(':nroDenuncia', $nroDenuncia);
			$response->bindParam(':ubicacionFisica', $ubicacionFisica);
			$response->bindParam(':codDepartamento', $codDepartamento);
			$response->bindParam(':codProvincia', $codProvincia);
			$response->bindParam(':codDistrito', $codDistrito);
			$response->bindParam(':anexoCaserio', $anexoCaserio);
			$response->bindParam(':fecha', $fecha);
			$response->bindParam(':usuario', $usuario);
			$response->bindParam(':idUsuario', $idUsuario);
			$response->execute();
			$response = null;
			return $config->lastInsertId();
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function modificar($solicitud){
		$referencia = 		$solicitud['referencia'];
		$fechaInicio = 		$solicitud['fechaInicio'];
		$delitoPrincipal = 	$solicitud['delitoPrincipal'];
		$codProcedencia = 	$solicitud['codProcedencia'];
		$codMotivo = 		$solicitud['codMotivo'];
		$proceso = 			$solicitud['proceso'];
		$organoJurisdiccional = $solicitud['organoJurisdiccional'];
		$sumilla = 			$solicitud['sumilla'];
		$ubicacion = 		$solicitud['ubicacion'];
		$parteProcesal = 	$solicitud['parteProcesal'];
		$codigo = 			$solicitud['codigo'];
		$expedienteOrigen = $solicitud['expedienteOrigen'];
		$juezPonente = 		$solicitud['juezPonente'];
		$especialistaLegal = $solicitud['especialistaLegal'];
		$abogadoResponsable = $solicitud['abogadoResponsable'];
		$fiscalia = 		$solicitud['fiscalia'];
		$fiscal = 			$solicitud['fiscal'];
		$comisaria = 		$solicitud['comisaria'];
		$nroCarpeta = 		$solicitud['nroCarpeta'];
		$nroDenuncia = 		$solicitud['nroDenuncia'];
		$ubicacionFisica = 	$solicitud['ubicacionFisica'];
		$codDepartamento = 	$solicitud['codDepartamento'];
		$codProvincia = 	$solicitud['codProvincia'];
		$codDistrito = 		$solicitud['codDistrito'];
		$anexoCaserio = 	$solicitud['anexoCaserio'];
		$fecha = 			$solicitud['fecha'];
		$idExpediente = 	$solicitud['idExpediente'];

		$sql = "UPDATE T_EXPEDIENTE SET referencia = :referencia,fecha_inicio = :fechaInicio,delito_principal = :delitoPrincipal,cod_procedencia = :codProcedencia,cod_motivo = :codMotivo,proceso = :proceso,organo_jurisdiccional = :organoJurisdiccional,sumilla = :sumilla,ubicacion = :ubicacion,parte_procesal = :parteProcesal,codigo = :codigo,expediente_origen = :expedienteOrigen,juez_ponente = :juezPonente,especialista_legal = :especialistaLegal,abogado_responsable = :abogadoResponsable,fiscalia = :fiscalia,fiscal = :fiscal,comisaria = :comisaria,nro_carpeta = :nroCarpeta,nro_denuncia = :nroDenuncia,ubicacion_fisica = :ubicacionFisica,cod_departamento = :codDepartamento,cod_provincia = :codProvincia,cod_distrito = :codDistrito,anexo_caserio = :anexoCaserio,fecha = :fecha
		WHERE id_expediente = '$idExpediente'";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':referencia', $referencia);
			$response->bindParam(':fechaInicio', $fechaInicio);
			$response->bindParam(':delitoPrincipal', $delitoPrincipal);
			$response->bindParam(':codProcedencia', $codProcedencia);
			$response->bindParam(':codMotivo', $codMotivo);
			$response->bindParam(':proceso', $proceso);
			$response->bindParam(':organoJurisdiccional', $organoJurisdiccional);
			$response->bindParam(':sumilla', $sumilla);
			$response->bindParam(':ubicacion', $ubicacion);
			$response->bindParam(':parteProcesal', $parteProcesal);
			$response->bindParam(':codigo', $codigo);
			$response->bindParam(':expedienteOrigen', $expedienteOrigen);
			$response->bindParam(':juezPonente', $juezPonente);
			$response->bindParam(':especialistaLegal', $especialistaLegal);
			$response->bindParam(':abogadoResponsable', $abogadoResponsable);
			$response->bindParam(':fiscalia', $fiscalia);
			$response->bindParam(':fiscal', $fiscal);
			$response->bindParam(':comisaria', $comisaria);
			$response->bindParam(':nroCarpeta', $nroCarpeta);
			$response->bindParam(':nroDenuncia', $nroDenuncia);
			$response->bindParam(':ubicacionFisica', $ubicacionFisica);
			$response->bindParam(':codDepartamento', $codDepartamento);
			$response->bindParam(':codProvincia', $codProvincia);
			$response->bindParam(':codDistrito', $codDistrito);
			$response->bindParam(':anexoCaserio', $anexoCaserio);
			$response->bindParam(':fecha', $fecha);
			$response->execute();
			$response = null;
			return $config->lastInsertId();
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function eliminar($solicitud){
		$idExpediente =		$solicitud['idExpediente'];
		$usuario = 			$solicitud['usuario'];

		$sql = "UPDATE T_EXPEDIENTE SET usuario_elimina = :usuario, fecha_eliminacion = now()
		WHERE id_expediente = :idExpediente";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':usuario', $usuario);
			$response->execute();
			$response = null;
			return $config->lastInsertId();
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function agregarParteProcesal($solicitud){
		$nombreCompleto = 	$solicitud['nombreCompleto'];
		$nroDocumento = 	$solicitud['nroDocumento'];
		$codTipoParte = 	$solicitud['codTipoParte'];
		$usuario = 			$solicitud['usuario'];
		$idExpediente =   	$solicitud['idExpediente'];

		$sql = "INSERT INTO T_PARTE_PROCESAL (nombre_completo,nro_documento,cod_tipo_parte,id_expediente,usuario_crea,fecha_creacion) 
		VALUES(:nombreCompleto, :nroDocumento, :codTipoParte, :idExpediente, :usuario, NOW())";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':nombreCompleto', $nombreCompleto);
			$response->bindParam(':nroDocumento', $nroDocumento);
			$response->bindParam(':codTipoParte', $codTipoParte);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':usuario', $usuario);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function agregarExpedienteArea($solicitud){
		$idExpediente = $solicitud['idExpediente'];
		$idArea = $solicitud['idArea'];
		$sql = "INSERT INTO T_EXPEDIENTE_AREA (id_expediente, id_area) VALUES(:idExpediente, :idArea)";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':idArea', $idArea);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function actualizarArea($solicitud){
		$idExpediente = $solicitud['idExpediente'];
		$idArea = $solicitud['idArea'];
		$sql = "UPDATE T_EXPEDIENTE_AREA SET id_area = :idArea WHERE id_expediente = :idExpediente";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':idArea', $idArea);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function actualizarEstado($solicitud){
		$idExpediente = $solicitud['idExpediente'];
		$codEstado = $solicitud['codEstado'];
		$sql = "UPDATE T_EXPEDIENTE SET cod_estado = :codEstado WHERE id_expediente = :idExpediente";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->prepare($sql);
			$response->bindParam(':idExpediente', $idExpediente);
			$response->bindParam(':codEstado', $codEstado);
			$response->execute();
			$response = null;
			$config = null;
		}catch(PDOException $ex){
			echo '{"text": '.$ex->getMessage().', "status": 0}';
		}
	}

	public function listaParteProcesal($solicitud){
		$idExpediente = $solicitud['idExpediente'];
		$sql = "SELECT pp.id_parte_procesal idParteProcesal,pp.nombre_completo nombreCompleto,pp.nro_documento nroDocumento,e.id_expediente idExpediente,pp.cod_tipo_parte codTipoParte 
		FROM T_PARTE_PROCESAL pp INNER JOIN T_EXPEDIENTE e ON e.id_expediente = pp.id_expediente 
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

	public function listaArea(){
		$sql = "SELECT id_area id, descripcion FROM T_AREA";
		try{
			$config = $this->container->get('db_connect');
			$response = $config->query($sql);
			$config = null;
			if($response->rowCount() > 0){
				return $response->fetchAll();
			}
			// return null;
		}catch(PDOException $ex){
			return json_decode('{"text": '.$ex->getMessage().', "status": "0"}');
		}
	}
}