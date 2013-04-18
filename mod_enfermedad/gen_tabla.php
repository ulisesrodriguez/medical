<?php 
require("../mod_configuracion/conexion.php");
//Segunda consulta para obtener la tabla
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
//$sql = "SELECT * FROM patologia where fecha between '". $_POST["firts_fech"] ."'and'". $_POST["second_fech"] ."' ORDER BY fecha asc";
$sql = "SELECT patologia_pac, COUNT(patologia_pac) AS cantidad FROM patologia 
 where fecha between '". $_POST["firts_fech"] ."'and'". $_POST["second_fech"] ."'  GROUP BY patologia_pac";
$res = mysql_query($sql, $con);
$table;
if(mysql_num_rows($res) == 0){
				  $table = "";
				  } else {
//Crea la tabla con los resultados
$table = "<table class='tabla'>
	           <tr>
			       <td class='tdatos'><h3>ENFERMEDAD</h3></td><td class='tdatos'><h3>NUMERO DE CASOS</h3></td>
			   </tr>";
	
	while( $tab = mysql_fetch_array($res)){
	
	 switch($tab["patologia_pac"]){
 case("ASM"):
 $patologia = strtoupper("asma");
 break;
 case("NEU"):
 $patologia = strtoupper("neumonia");
 break;
 case("CAR"):
 $patologia = strtoupper("cardiopatia");
 break;
 case("HIP"):
 $patologia = strtoupper("hipertencion");
 break;
 case("VAR"):
 $patologia = strtoupper("varices");
 break;
 case("DES"):
 $patologia = strtoupper("desnutricion");
 break;
 case("DIA"):
 $patologia = strtoupper("diabetes");
 break;
 case("ENF"):
 $patologia = strtoupper("enf.renal");
 break;
 case("CAN"):
 $patologia = strtoupper("cancer");
 break;
 case("TUM"):
 $patologia = strtoupper("tumor mamario");
 break;
 case("DEN"):
 $patologia = strtoupper("dengue");
 break;
 case("OBE"):
 $patologia = strtoupper("obecidad");
 break;
 case("ENF"):
 $patologia = strtoupper("enf.t.s");
 break;
 case("ACV"):
 $patologia = strtoupper("acv");
 break;
 case("otr"):
 $patologia = strtoupper("otros");
 break;
 default:
 $patologia = "";
 break;
 
 }
$table .= "<tr>
	           <td class='tdatos'>". $patologia ."</td><td class='dtabla'>". $tab["cantidad"] ."</td>
	          </tr>";
}
    $table .= "</table>";
	echo $table;
}
?>