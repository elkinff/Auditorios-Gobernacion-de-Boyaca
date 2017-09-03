<?php
	require_once("Include.php");

	class Auditorio{
		
		function Auditorio(){
		}

		public function cargarAuditorios(){
			$ObjDB= new ConexionBD();
			$strSQL="SELECT * FROM Auditorio";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;
		}
	}
?>