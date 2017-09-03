<?php
	require_once("Include.php");

	class Persona{

		function Persona(){
			# code...
		}

		public function isPersona($dato){
			$ObjDB= new ConexionBD();
			if (is_string($dato))
				$campo = "contrasena_persona";
			else
				$campo = "cedula_persona";
			
			$strSQL="SELECT * FROM Persona WHERE '".$campo."'=".$dato."";
			//$arr=$ObjDB->db_result_to_array($strSQL);
			if($ObjDB->db_query_numfilas!=0){
				$existe=1;
			}else{
				$existe=0;
			}	
			$ObjDB=NULL;
			return $existe;  
		}

		public function loginPersona($cedula, $contrasena){
			$ObjDB= new ConexionBD();
			$strSQL="SELECT * FROM Persona WHERE cedula_persona=".$cedula." AND contrasena_persona='".$contrasena."'";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;	
		}


		public function insertarPersonaFuncionario($cedula, $nombre, $apellidos, $celular, $telefono, $extencion, $dependencia, $correo, $contrasena, $jefe){
			$ObjDB = new ConexionBD();
			$strSQL= "INSERT INTO Persona (cedula_persona, nombre_persona, dependencia_persona, correo_persona, celular_persona, telefono_persona, contrasena_persona, tipo_persona, jefe_inmediato_persona)";
			$strSQL= $strSQL."VALUES (".$cedula.",'".$nombre." ".$apellidos."','".$dependencia."', '".$correo."', ".$celular.", ".$telefono.$extencion.", '".$contrasena."','FU', '".$jefe."' )";
			echo $strSQL;
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function insertarPersonaAdministrador($cedula, $nombre, $apellidos, $celular, $telefono, $extencion, $dependencia, $correo, $contrasena, $jefe){
			$ObjDB = new ConexionBD();
			$strSQL= "INSERT INTO Persona (cedula_persona, nombre_persona, dependencia_persona, correo_persona, celular_persona, telefono_persona, contrasena_persona, tipo_persona, jefe_inmediato_persona)";
			$strSQL= $strSQL."VALUES (".$cedula.", '".$nombre.$apellidos."', '".$dependencia."','".$correo."', ".$celular.", ".$telefono.$extencion.", '".$contrasena."', 'FA', '".$jefe."' )";
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function cargarDatosFormulario($cedula_persona_solicita){
			$ObjDB = new ConexionBD();
			$strSQL="SELECT * FROM Persona WHERE cedula_persona='".$cedula_persona_solicita."'";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;			
		}

		public function cargarAdministradores(){
			$ObjDB = new ConexionBD();
			$strSQL="SELECT * FROM Persona WHERE tipo_persona='FA'";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;			
		}

		public function actualizarAdministrador($cedula, $nombre, $dependencia, $correo, $celular){
			$ObjDB = new ConexionBD();
			$strSQL="UPDATE persona SET nombre_persona =  '".$nombre."', dependencia_persona = '".$dependencia."', correo_persona =  '".$correo."', celular_persona =".$celular." WHERE cedula_persona = ".$cedula."";
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;		
		}

	}
?>