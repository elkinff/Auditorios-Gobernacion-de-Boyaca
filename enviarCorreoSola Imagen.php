<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-type: text/json');
			
	$lugar = $_POST['lugar']; 
	$descripcion = $_POST['descripcion'];
	$correo = $_POST['correo'];

	$nombreImagen1=$_FILES['file1']['name'];
	$tamanoArchivo1 = $_FILES['file1']['size'];
	$tipoArchivo1 = $_FILES['file1']['type'];

	$nombreImagen2=$_FILES['file2']['name'];
	$tamanoArchivo2 = $_FILES['file2']['size'];
	$tipoArchivo2 = $_FILES['file2']['type'];

	$para      = 'lapptiveco@gmail.com';  
	$titulo    = 'Denuncia de maltrato animal';
	$titulo    = 'Denuncia de maltrato animal';

	$cabeceras 	= "MIME-version: 1.0\r\n";
	$cabeceras .= "Content-type: multipart/mixed;";
	$cabeceras .= "boundary=\"=C=T=E=C=\"\r\n";
	$cabeceras .= "From: ".$correo;

	$body_top  = "--=C=T=E=C=\r\n";
	$body_top .= "Content-Transfer-Encoding: 8bit\r\n";
	$body_top .= "Content-description: Mail message body"."\n";
	$body_top .= "\r\n";
	$body_top .= $descripcion."\n"."Lugar: ".$lugar. "\r\n";
	$body_top .= "\r\n";

	if($tamanoArchivo1>0){
		$nombreImagen=$nombreImagen1;
		$tamanoArchivo=$tamanoArchivo1;
		$tmpName=$_FILES["file1"]["name"];
	}else{
		$nombreImagen=$nombreImagen2;
		$tamanoArchivo=$tamanoArchivo2;
		$tmpName=$_FILES["file2"]["name"];
	}

	$body_top .= "--=C=T=E=C=\r\n";
	$body_top .= "Content-Type: application/octet-stream; ";
	$body_top .= "name=". $nombreImagen."\r\n";
	$body_top .= "Content-Transfer-Encoding: base64\r\n";
	$body_top .= "Content-Disposition: attachment; ";
	$body_top .= "filename=".$nombreImagen."\r\n";
	$body_top .= "\r\n";

	$fp = fopen($tmpName, "rb"); 
	$file = fread($fp, $tamanoArchivo);
	$file = chunk_split(base64_encode($file));

	$body_top .= "$file\r\n";
	$body_top .= "\r\n";
	$body_top .= "--=C=T=E=C=--\r\n";

	if ((filter_var($correo, FILTER_VALIDATE_EMAIL)) && (strlen($correo)>=7)){
		if($tamanoArchivo>0){
			if (mail($para, $titulo, $body_top, $cabeceras)){
				$ar = array('mensaje' => "La Denuncia ha sido enviada.", 'respuesta' => 'SI' );		
			}else{
				$ar = array('mensaje' => "La denuncia no ha sido enviada, revisa los datos.", 'respuesta' => 'NO' );		
			}
		}else{
			$ar = array('mensaje' => "No se ha ingresado una imagen.", 'respuesta' => 'NO' );			
		}
	}else{
		$ar = array('mensaje' => "Ingresa un correo electronico valido.", 'respuesta' => 'NO' );	
	}  
	print(json_encode($ar));
?> 