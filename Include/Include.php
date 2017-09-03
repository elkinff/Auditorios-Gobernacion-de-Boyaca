<?php
	require_once("Configuracion.php");

	class ConexionBD{
		var $hostname;
		var $database;
		var $username;
		var $password;
		var $db_query_numfilas;

	function ConexionBD(){
		$ObjConf= new Configuracion();
	 	$this->hostname = $ObjConf->getHostName();
	 	$this->database = $ObjConf->getDataBase();
	 	$this->username = $ObjConf->getUserName();
	 	$this->password = $ObjConf->getPassword();
	 	$this->db_query_numfilas=0;
	 	$ObjConf=NULL;
	}
	
	function db_result_to_array($strSQL){
		try {

			$conn=mysql_connect($this->hostname,$this->username,$this->password) or die (mysql_error());
			mysql_select_db($this->database,$conn);
			$resultado=mysql_query($strSQL,$conn);
			$this->db_query_numfilas=mysql_num_rows($resultado);
			$this->db_query_numcols=mysql_num_fields($resultado); 
					
			$res_array = array();
			
			for ($count=0 ; $row = mysql_fetch_array($resultado); $count++)
				$res_array[$count]=$row;
			mysql_free_result($resultado);
			mysql_close($conn);	
	
			return $res_array ;
		} 

		catch (Exception $e) {
    	}
	}

	function db_valor($strSQL){
		try
		{
			$conn=mysql_connect($this->hostname,$this->username,$this->password) or die (mysql_error());
			mysql_select_db($this->database,$conn);
			$resultado=mysql_query($strSQL,$conn);
			$this->db_query_numfilas=mysql_num_rows($resultado);
					
			$res_array = array();
			
			for ($count=0 ; $row = mysql_fetch_array($resultado); $count++)
				$res_array[$count]=$row;
			mysql_free_result($resultado);
			mysql_close($conn);	
		
			if($this->db_query_numfilas!=0)
			{
				return $res_array[0][0];
			}
			else
			{
				return "";
			}
		}
		catch (Exception $e) 
		{
		}
	}
	
	function db_existe($strSQL)
	{
		try
		{
			$conn=mysql_connect($this->hostname,$this->username,$this->password) or die (mysql_error());
			mysql_select_db($this->database,$conn);
			$resultado=mysql_query($strSQL,$conn);
			$this->db_query_numfilas=mysql_num_rows($resultado);
			if($this->db_query_numfilas==0)
			{
				return 0;
			}				
			else
			{
				return 1;
			}
		}
		catch (Exception $e) 
		{
		}
	}
		
	function db_query($strSQL)
	{
		try
		{
			$conn=mysql_connect($this->hostname,$this->username,$this->password);
			mysql_select_db($this->database,$conn);
			mysql_query($strSQL,$conn) or die (mysql_error());
			$this->db_query_numfilas=0;
			mysql_close($conn);	
		}
		catch (Exception $e) 
		{
		}
	}

	function ObtenerValor($strCadena,$strParametro)
	{
			$Cadena1= stristr($strCadena,$strParametro);
			$Valor1=stristr($Cadena1,"=");
			$pos=strpos($Valor1,";");
			return substr($Valor1,1,$pos-1);
	}

	function db_result_table($strSQL)
	{
	try {

		$conn=mysql_connect($this->hostname,$this->username,$this->password) or die (mysql_error());
		mysql_select_db($this->database,$conn);
		$resultado=mysql_query($strSQL,$conn);
		$this->db_query_numfilas=mysql_num_rows($resultado);
		$this->db_query_numcols=mysql_num_fields($resultado); 
				
		$res_array = array();
		
		$arr_cabecera=array();
		$i = 0;
		while ($i < mysql_num_fields($resultado)) 
		{
			$meta = mysql_fetch_field($resultado, $i);
			$arr_cabecera[$i]="<strong>".$meta->name."</strong>";
			$i=$i+1;
		}
		
		$res_array[0]=$arr_cabecera;
		
		for ($count=1 ; $row = mysql_fetch_array($resultado); $count++)
			$res_array[$count]=$row;
		mysql_free_result($resultado);
		mysql_close($conn);	
	
		return $res_array ;
	} 

		catch (Exception $e) 
		{
		}
	}

	function MostrarTabla($strSQL)
	{
		$arr_tabla=$this->db_result_table($strSQL);
		
		for($i=0;$i<$this->db_query_numfilas;$i++)
		{
			for($j=0;$j<$this->db_query_numcols;$j++)
			{
			}
		}
	}
}
?>

