<?php
	header('Access-Control-Allow-Origin: *');
	//session_start();
	
	require_once("../Include/Reserva.php");

	$codigoAuditorio=$_GET['codigoAuditorio'];
	$fechaInicio=$_GET['fechaInicio'];
	$fechaFinal=$_GET['fechaFinal'];
	
	$oReserva = new Reserva();	
	$consultaReserva = $oReserva->consultarFechaReserva($codigoAuditorio,$fechaInicio,$fechaFinal);

	if ($consultaReserva==0) {//NO hay reservas para este auditorio
		$data = array('respuesta' => 0);
	}else{
		$data = array('respuesta' => 1);
	}
	$ar[]=$data;
	echo json_encode($ar);
?>