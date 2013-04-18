<?php 
require("../theme/header_inicio.php");
require("format_date.php");

//Crea una select con las fechas registradas en la tabla patologia para seleccionar un rango de fechas
$sql_fecha = "SELECT DISTINCT fecha FROM patologia ORDER BY fecha asc";
$res_fecha = mysql_query($sql_fecha,  db_conexion() );
$opciones = '<option value="0"> Elije una fecha </option>';
while( $fila = mysql_fetch_array($res_fecha) ){
//	$opciones .= "<option value=". $fila["fecha"] .">". $fila["fecha"] ."</option>";
//Tranformacion de tipo de fecha
	$date = explode("-", $fila["fecha"]);
	$ano = $date[0];
	$mes = $date[1];
	$dia = $date[2];
	$mes = meses($mes); 
	$fecha = fecha_completa($dia, $mes, $ano);
	$opciones .= "<option value=". $fila["fecha"] .">". $fecha ."</option>";
	}
?>
<br />
		<div align="center" class="titulo"> Seleccion de fechas. </div>
<br />
<br />
		<table align="center">
		
		<tr> 
			<td>De:</td>
			<td> <select id="de"><?php echo $opciones; ?></select>  </td>
			<td>A:</td>
			<td><td><select id="a">
			<option value="0">Elije otra fecha</option>
			</select>
			</td> 
		</tr> 	
       </table>
       
       <div align="center" id= "data_table" style="margin-top:50px; margin-bottom:100px;">
       
       </div>
<?php
include("../theme/footer_inicio.php");
?>
