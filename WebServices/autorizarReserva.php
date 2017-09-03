<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Reserva.php");

	$oReserva = new Reserva();

	$codigoReserva = $_POST['codigoReserva'];
	$cedulaAprueba= $_POST['cedulaAprueba'];
	//$email= $_POST['email'];

	$oReserva->autorizarReserva($codigoReserva, $cedulaAprueba);
	
	// $titulo    = 'Correo';
	// $cabeceras = 'From:elkin9309@gmail.com';

	// $mensaje   = "Se aprobo tu solicitud";

	// //echo $email, $titulo, $cabeceras, $mensaje;
	// //mail("elkin9309@hotmail.com", $titulo, $mensaje);

	// if (mail($email, $titulo, $mensaje)) {
	// 	echo ' envio';
	// } else {
	// 	echo 'Falló el envio';
	// }
?>