<?php
	header('Access-Control-Allow-Origin: *');
	
	if (!isset($_SESSION)) {
	 	session_start();
	}
	require_once("../Include/Persona.php");

	$cedula=$_POST['cedula'];
	$contrasena=$_POST['contrasena'];

	$oPersona = new Persona();
	$personaData=$oPersona->loginPersona($cedula, $contrasena);

	if(count($personaData)==1){
		$ar =  array();
		$data = array(
				'cedula'		=> $personaData[0]['cedula_persona'],
				'nombre'		=> $personaData[0]['nombre_persona'],
				'tipo'     	 	=> $personaData[0]['tipo_persona'],
				'dependencia' 	=> $personaData[0]['dependencia_persona'],
				'celular' 		=> $personaData[0]['celular_persona'],
				'telefono' 		=> $personaData[0]['telefono_persona'],
		);
		$ar[]=$data;

		echo json_encode($ar);
	}
?>