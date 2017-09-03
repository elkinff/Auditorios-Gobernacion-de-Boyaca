<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../Include/Persona.php");

	$nombres=$_POST['nombres'];
	$apellidos=$_POST['apellidos'];
	$cedula=$_POST['cedula'];
	$celular=$_POST['celular'];
	$telefono=$_POST['telefono'];
	$extension=$_POST['extension'];
	$sectorial=$_POST['sectorial'];
	$correo=$_POST['correo'];
	$contrasena=$_POST['contrasena'];
	$jefe=$_POST['jefe'];

	$oPersona = new Persona();

	if($oPersona->isPersona($correo)==0){
		$oPersona->insertarPersonaFuncionario($cedula, $nombres, $apellidos, $celular,  $telefono, $extension, $sectorial, $correo, $contrasena, $jefe);
	}
?>