<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$oReserva = new Reserva();
	$oReservaData=$oReserva->cargarReservas();
	$ar =  array();

	for($i=0; $i<count($oReservaData); $i++){
		$data = array(
			'codigo'		 		=> $oReservaData[$i]['codigo_reserva'],
			'nombre_persona'		=> $oReservaData[$i]['nombre_persona'],
			'nombre_auditorio'	    => $oReservaData[$i]['nombre_auditorio'],
		   	'dependencia_persona'	=> $oReservaData[$i]['dependencia_persona'],
			'fecha_inicio'	 	 	=> $oReservaData[$i]['fecha_inicio_reserva'],
			'fecha_final'	 	 	=> $oReservaData[$i]['fecha_final_reserva'],
			'aprobada'	 	 		=> $oReservaData[$i]['aprobada_reserva'],
		);
		$ar[]=$data;
	}
	echo json_encode($ar);
?>