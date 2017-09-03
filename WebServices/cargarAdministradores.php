<?php
	header('Access-Control-Allow-Origin: *');

	require_once("../Include/Persona.php");

	$oPersona = new Persona();
	$oPersonaData = $oPersona -> cargarAdministradores();
	$ar = array();

	for($i=0; $i<count($oPersonaData); $i++){
		$data = array(
			'cedula'    	 => $oPersonaData[$i]['cedula_persona'],		              
			'nombre'     	 => $oPersonaData[$i]['nombre_persona'],
			'dependencia'		 => $oPersonaData[$i]['dependencia_persona'],
			'correo'     	 => $oPersonaData[$i]['correo_persona'],
		    'celular'      	 => $oPersonaData[$i]['celular_persona'],
		);
		$ar[]=$data;
	}
	echo json_encode($ar);
?>