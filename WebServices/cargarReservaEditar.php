<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$codigo= $_GET['codigo'];

	$oReserva = new Reserva();

	$oReservaData=$oReserva->cargarReservaCodigo($codigo);
	$ar =  array();

	for($i=0; $i<count($oReservaData); $i++){
		$data = array(
			'nombre_persona' 		=> $oReservaData[$i]['nombre_persona'],
			'dependencia' 			=> $oReservaData[$i]['dependencia_persona'],
			'fecha_inicio'	 	 	=> $oReservaData[$i]['fecha_inicio_reserva'],
			'fecha_final'	 	 	=> $oReservaData[$i]['fecha_final_reserva'],
			'codigo_auditorio'	 	=> $oReservaData[$i]['codigo_auditorio'],
			'nombre_auditorio'	 	=> $oReservaData[$i]['nombre_auditorio'],
			'fecha'		 			=> $oReservaData[$i]['fecha_reserva'],
			'mantenimiento'		 	=> $oReservaData[$i]['tipo_reserva'],
			'apoyo'		 			=> $oReservaData[$i]['apoyo_logistico_reserva'],
			'descripcion'		 	=> $oReservaData[$i]['descripcion_reserva'],
		);	
		$ar[]=$data;
	}
	echo json_encode($ar);
?>