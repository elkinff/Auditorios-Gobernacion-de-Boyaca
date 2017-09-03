<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$oReserva = new Reserva();

	$codigo = $_POST['codigo'];
	$observaciones= $_POST['observaciones'];

	$oReserva->calificarReserva($codigo, $observaciones);
	echo "Actualizado";
?>