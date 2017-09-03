<?php
	header('Access-Control-Allow-Origin: *');

	session_start();

	require_once("../Include/Reserva.php");

	$oReserva = new Reserva();
	$oReservaData = $oReserva -> cargarReservasPorFuncionario($_SESSION['cedula']);
	$ar =  array();

	for($i=0; $i<count($oReservaData); $i++){
		$data = array(
			'codigo'     	 => $oReservaData[$i]['codigo_reserva'],
			'fechaInicio'    => $oReservaData[$i]['fecha_inicio_reserva'],
			'fechaFinal'     => $oReservaData[$i]['fecha_final_reserva'],
			'nombreAuditorio'=> $oReservaData[$i]['nombre_auditorio'],
		    'estado'         => $oReservaData[$i]['aprobada_reserva'],
		);
		$ar[]=$data;
	}
	echo json_encode($ar);
?>