<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Persona.php");

	$oPersona = new Persona();

	$cedula = $_POST['cedula'];
	$nombre= $_POST['nombre'];
	$dependencia = $_POST['dependencia'];
	$correo= $_POST['correo'];
	$celular= $_POST['celular'];
	
	
	$oPersona->actualizarAdministrador($cedula, $nombre, $dependencia, $correo, $celular);
?>