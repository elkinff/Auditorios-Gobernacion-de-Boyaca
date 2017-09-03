<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$cedula= $_GET['cedula'];

	$oReserva = new Reserva();

	$oReservaData=$oReserva->cargarReservasPorFuncionario($cedula);
	$ar =  array();

	for($i=0; $i<count($oReservaData); $i++){
		$data = array(
			'codigo'		 		=> $oReservaData[$i]['codigo_reserva'],
			'nombre_auditorio'	    => $oReservaData[$i]['nombre_auditorio'],
		   	'fecha_inicio'	 	 	=> $oReservaData[$i]['fecha_inicio_reserva'],
			'fecha_final'	 	 	=> $oReservaData[$i]['fecha_final_reserva'],
			'observaciones'	 	 	=> $oReservaData[$i]['observaciones_reserva'],
			'aprobada'	 	 		=> $oReservaData[$i]['aprobada_reserva'],
		);
		$ar[]=$data;
	}
	echo json_encode($ar);
?>