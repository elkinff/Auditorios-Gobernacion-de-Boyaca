<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$oReserva = new Reserva();

	$codigo_reserva = $_POST['codigo_reserva'];
	$codigo_auditorio= $_POST['codigo_auditorio'];
	$fecha_inicio= $_POST['fecha_inicio'];
	$fecha_final= $_POST['fecha_final'];
	$tipo= $_POST['tipo'];
	$apoyo_logistico= $_POST['apoyo_logistico'];
	$descripcion= $_POST['descripcion'];


	$oReserva->editarReserva($codigo_reserva, $codigo_auditorio, $fecha_inicio, $fecha_final, $tipo, $apoyo_logistico, $descripcion);
?>