<?php
	header('Access-Control-Allow-Origin: *');

	require_once("../Include/Auditorio.php");

	$oAuditorio = new Auditorio();
	$oAuditorioData = $oAuditorio -> cargarAuditorios();
	$ar = array();

	for($i=0; $i<count($oAuditorioData); $i++){
		$data = array(
			'codigo'     	 => $oAuditorioData[$i]['codigo_auditorio'],
			'cedula'    	 => $oAuditorioData[$i]['cedula_persona'],
			'nombre'     	 => $oAuditorioData[$i]['nombre_auditorio'],
			'imagen'		 => $oAuditorioData[$i]['imagen_auditorio'],
		    'capacidad'      => $oAuditorioData[$i]['capacidad_auditorio'],
		    'direccion'		 => $oAuditorioData[$i]['direccion_auditorio'],
		);
		$ar[]=$data;
	}
	echo json_encode($ar);
?>