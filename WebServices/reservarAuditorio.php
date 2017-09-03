<?php
	require_once("../Include/Reserva.php");

	$cedula=$_POST['cedula'];
	$auditorio=$_POST['auditorio'];
	$fechaInicio=$_POST['fechaInicio'];
	$fechaFinal=$_POST['fechaFinal'];
	$tipo=$_POST['tipo'];
	$apoyo=$_POST['apoyo'];
	$descripcion=$_POST['descripcion'];
	$fecha=$_POST['fecha'];

	$oReserva = new Reserva();
	
	$oReserva->insertarReserva($cedula, $auditorio, $fechaInicio, $fechaFinal, $tipo, $apoyo, $descripcion, $fecha);
?>