<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$oReserva = new Reserva();

	$id = $_POST['id'];
	
	if ($id!="") {
		$oReserva->eliminarReserva($id);
	}
?>