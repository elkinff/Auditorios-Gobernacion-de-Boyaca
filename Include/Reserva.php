<?php
	require_once("Include.php");

	class Reserva{
		
		function Reserva(){
		}

		public function cargarReservas(){
			$ObjDB= new ConexionBD();
			$strSQL="SELECT r.codigo_reserva, p.nombre_persona, a.nombre_auditorio, p.dependencia_persona, r.fecha_inicio_reserva, r.fecha_final_reserva, r.aprobada_reserva FROM reserva r, persona p, auditorio a WHERE r.cedula_persona_solicita = p.cedula_persona AND a.codigo_auditorio = r.codigo_auditorio ORDER BY r.fecha_inicio_reserva DESC LIMIT 0 , 30";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;
		}

		public function cargarReservasPorFuncionario($cedula_persona_solicita){
			$ObjDB= new ConexionBD();
			$strSQL="SELECT r.codigo_reserva, r.fecha_inicio_reserva, r.fecha_final_reserva, a.nombre_auditorio, r.observaciones_reserva, r.aprobada_reserva FROM Reserva r, Auditorio a WHERE r.cedula_persona_solicita = ".$cedula_persona_solicita." AND r.codigo_auditorio = a.codigo_auditorio";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;
		}

		public function insertarReserva($cedula_persona_solicita, $codigo_auditorio, $fecha_inicio_reserva, $fecha_final_reserva, $tipo_reserva, $apoyo_logistico_reserva, $descripcion_reserva, $fecha){
			$ObjDB = new ConexionBD();
			$strSQL= "INSERT INTO Reserva (codigo_reserva, cedula_persona_solicita, cedula_persona_aprueba, codigo_auditorio, fecha_inicio_reserva, fecha_final_reserva, tipo_reserva, apoyo_logistico_reserva, descripcion_reserva, aprobada_reserva, observaciones_reserva, fecha_reserva)";
			$strSQL= $strSQL."VALUES (NULL, ".$cedula_persona_solicita.", NULL, ".$codigo_auditorio.", '".$fecha_inicio_reserva."', '".$fecha_final_reserva."', '".$tipo_reserva."', '".$apoyo_logistico_reserva."', '".$descripcion_reserva."',0,NULL, '".$fecha."')";
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function calificarReserva($codigo_reserva, $observaciones){
			$ObjDB = new ConexionBD();
			$strSQL= "UPDATE  reserva SET  aprobada_reserva =  1, observaciones_reserva='".$observaciones."' WHERE  codigo_reserva =".$codigo_reserva;
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function consultarFechaReserva($codigo_auditorio, $fechaInicio, $fechaFinal){
			$ObjDB = new ConexionBD();
			$strSQL="SELECT * FROM Reserva WHERE codigo_auditorio =".$codigo_auditorio." AND ((fecha_inicio_reserva BETWEEN  '".$fechaInicio."' AND '".$fechaFinal."' OR fecha_final_reserva BETWEEN '".$fechaInicio."' AND  '".$fechaFinal."') OR('".$fechaInicio."' BETWEEN fecha_inicio_reserva AND fecha_final_reserva OR '".$fechaFinal."' BETWEEN fecha_inicio_reserva AND fecha_final_reserva))";
			$arr=$ObjDB->db_result_to_array($strSQL);
			if($ObjDB->db_query_numfilas!=0){
				$existe=1;
			}else{
				$existe=0;
			}	
			$ObjDB=NULL;
			return $existe;
		}

		public function eliminarReserva($codigo_reserva){
			$ObjDB = new ConexionBD();
			$strSQL= "DELETE FROM Reserva WHERE codigo_reserva =".$codigo_reserva."";
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function autorizarReserva($codigo_reserva, $cedula_persona_aprueba){
			$ObjDB = new ConexionBD();
			$strSQL= "UPDATE Reserva SET aprobada_reserva = 1, cedula_persona_aprueba = ".$cedula_persona_aprueba." WHERE codigo_reserva=".$codigo_reserva."";	
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function editarReserva($codigo_reserva, $codigo_auditorio,$fecha_inicio_reserva, $fecha_final_reserva, $tipo_reserva, $apoyo_logistico_reserva, $descripcion_reserva){
			$ObjDB = new ConexionBD();
			$strSQL= "UPDATE Reserva SET  codigo_auditorio=".$codigo_auditorio.", fecha_inicio_reserva ='".$fecha_inicio_reserva."', fecha_final_reserva='".$fecha_final_reserva."', tipo_reserva='".$tipo_reserva."', apoyo_logistico_reserva='".$apoyo_logistico_reserva."', descripcion_reserva='".$descripcion_reserva."' where codigo_reserva=".$codigo_reserva."";
			$ObjDB->db_query($strSQL);
			$ObjDB=NULL;
		}

		public function cargarReservaCodigo($codigo_reserva){
			$ObjDB= new ConexionBD();
			$strSQL="SELECT r.codigo_reserva, p.nombre_persona, p.dependencia_persona, r.fecha_inicio_reserva, r.fecha_final_reserva, r.codigo_auditorio, a.nombre_auditorio, r.fecha_reserva, r.tipo_reserva, r.apoyo_logistico_reserva, r.descripcion_reserva FROM Reserva r, Auditorio a, Persona p WHERE p.cedula_persona = r.cedula_persona_solicita AND r.codigo_auditorio = a.codigo_auditorio AND r.codigo_reserva=".$codigo_reserva."";
			$arr=$ObjDB->db_result_to_array($strSQL);
			return $arr;
			$ObjDB=NULL;
		}

	}
?>