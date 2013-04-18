<?php
require("../mod_configuracion/conexion.php");
require("format_date.php");
/*******************************************************************
**************     Medical Center Version 1.0.1    *****************
********************************************************************
***************  @Author ISC.Ulises Rodriguez T.   *****************
********************************************************************
***************   @Author Ing.Jorge Hernández.     *****************
********************************************************************
***************          @copyright 2010           ***************** 
********************************************************************
***************           @No modificar            *****************
********************************************************************/
$post_fecha = $_POST["idmarca"];
if($post_fecha == 0){
	$post_fecha = "now()";
	}
//Primer Consulta
$sql_fecha = "SELECT DISTINCT fecha FROM patologia where fecha > '". $post_fecha ."' ORDER BY fecha asc";
$res_fecha = mysql_query($sql_fecha, $con); 
	

if(isset($_POST["idmarca"]))

{
		$opciones = '<option value="0"> Elije otra fecha </option>';
        /***************************************************
		************** Array de fechas **********************
		***************************************************/
		    $fecha = array();
   				    
			while($reg = mysql_fetch_array($res_fecha)){
			
		    /**************************************************
			************** Formato de fechas ******************
			**************************************************/
			 if($reg == 0){
				 $opciones = 'Elije otra fecha';
				 } else {
			    $date = explode("-", $reg["fecha"]);
			   	 				   		
				for($i=0; $i<=sizeof($date); $i++){
			    
			     	$ano = $date[0];
		    		$mes = $date[1];
			    	$dia = $date[2];
			    			   	   			 								
			     }
			     $fecha = fecha_completa($dia, $mes, $ano);
			    	
					$opciones .= "<option value=". $reg["fecha"] .">".  $fecha ."</option>";
					
				 }
			    }
				
				 echo $opciones;
				}
				
				
				
	
?>
