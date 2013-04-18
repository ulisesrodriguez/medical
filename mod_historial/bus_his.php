<?php
require("../theme/header_inicio.php");
?>
<br />
<div class="titulo">Consulta de Historial de Paciente</div><br /><br />
<div align="center">
<table>
<td>
<form action="bus_his.php">
		<input type="hidden" name="busqueda" value="apellido">
		<table class="tabla">
		<tr>
			<td colspan="2" align="center">Introduzca Apellido</td>
		</tr>
		<tr>
			<td><input type="text" name="ape" value="<?php if( isset( $_POST["ape"] ) ) echo $_POST["ape"]; ?>" size="20"></td>
			<td><input type="submit" value="Buscar"></td>
		</tr>
		</table>
	</form>
</td>
<td>
<form action="bus_his.php">
		<input type="hidden" name="busqueda" value="nombre">
		<table class="tabla">
		<tr>
			<td colspan="2" align="center">Ingrese Nombre</td>
		</tr>
		<tr>
			<td><input type="text" name="nom" value="<?php if( isset( $_POST["nom"] ) ) echo $_POST["nom"]; ?>" size="20"></td>
			<td><input type="submit" value="Buscar"></td>
		</tr>
		</table>
	</form>
</td>
<tr>
<td>
	<form action="bus_his.php">
		<input type="hidden" name="busqueda" value="estatus">
		<table class="tabla">
		<tr>
			<td colspan="2" align="center">Consulta por Estatus</td>
		</tr>
		<tr>
		<td>
		<select name="est">
			<option value="">Seleccione</option>
			<option value="0" <?php if ( isset( $_POST["est"] ) and $_POST["est"] =="0") echo "selected" ?>>AMBOS</option>
			<option value="A" <?php if ( isset( $_POST["est"] ) and $_POST["est"] =="A") echo "selected" ?>>ACTIVOS</option>
			<option value="I" <?php if ( isset( $_POST["est"] ) and $_POST["est"] =="I") echo "selected" ?>>INACTIVOS</option>
		</select>
			</td>
			<td><input type="submit" value="Buscar"></td>
		</tr>
		</table>
	</form>
	</td>
</td>

</table>
</div>
<br />
<?php
if( isset( $_POST["busqueda"] ) and  $_POST["busqueda"]!=""){
switch($_POST["busqueda"]){
	case'cedula':
	$resultado=mysql_query("
SELECT A.*,B.*,C.*,D.*,E.*
FROM	paciente A,
	expediente B,
	historial C,
	profesional D, 
	sala E 
WHERE A.ced='".quitar($_POST["ced"])."' AND A.ced=B.ced_paciente AND
	B.ced_exp=C.dni_historial AND
	C.ced_prof=D.ced_prof AND B.sala=E.id_sala
", db_conexion() );

	if(mysql_num_rows($resultado) == 1){
	$cedula=mysql_result($resultado,0,"ced");
	$id_pac=mysql_result($resultado,0,"id_paciente");
	$id_exp=mysql_result($resultado,0,"dni_exp");
	$est_exp=mysql_result($resultado,0,"estado_exp");
	$nombre=mysql_result($resultado,0,"nombre");
	$apellido=mysql_result($resultado,0,"apellido");
	$sexo=mysql_result($resultado,0,"sexo");
	$nomrep=mysql_result($resultado,0,"nombre_representante");
	$foto=mysql_result($resultado,0,"foto");
	$sala=mysql_result($resultado,0,"denominacion");
	$dia1=substr(mysql_result($resultado,0,"fec_nac"),8,2);
	$mes1=substr(mysql_result($resultado,0,"fec_nac"),5,2);
	$ano1=substr(mysql_result($resultado,0,"fec_nac"),0,4);
	$dia=substr(mysql_result($resultado,0,"fec_gen_hist"),8,2);
	$mes=substr(mysql_result($resultado,0,"fec_gen_hist"),5,2);
	$ano=substr(mysql_result($resultado,0,"fec_gen_hist"),0,4);
	$observa=mysql_result($resultado,0,"observacion");
	$diagnostico=mysql_result($resultado,0,"diagnostico");
	$tratamiento=mysql_result($resultado,0,"tratamiento");
	$receta=mysql_result($resultado,0,"receta");	
	$nomprf=mysql_result($resultado,0,"nombre_apellido");
	}
	break;
	case'nombre':
	$resultado=mysql_query("
SELECT A.*,B.*,C.*,D.*,E.*
FROM	paciente A,
	expediente B,
	historial C,
	profesional D, 
	sala E 
WHERE A.nombre LIKE '%".strtoupper($_POST["nom"])."%' AND A.ced=B.ced_paciente AND
	B.ced_exp=C.dni_historial AND
	C.ced_prof=D.ced_prof AND B.sala=E.id_sala 
ORDER BY ced desc", db_conexion() );
	break;
	case'apellido':
	$resultado=mysql_query("
SELECT A.*,B.*,C.*,D.*,E.*
FROM	paciente A,
	expediente B,
	historial C,
	profesional D, 
	sala E 
WHERE A.apellido LIKE '%".strtoupper($_POST["ape"])."%' AND A.ced=B.ced_paciente AND
	B.ced_exp=C.dni_historial AND
	C.ced_prof=D.ced_prof AND B.sala=E.id_sala 
ORDER BY ced desc", db_conexion() );
	break;
	case'estatus':
	if( $_POST["est"] =="0"){
	$resultado=mysql_query("
SELECT A.*,B.*,C.*,D.*,E.*
FROM	paciente A,
	expediente B,
	historial C,
	profesional D, 
	sala E 
WHERE 	A.ced=B.ced_paciente AND
	B.ced_exp=C.dni_historial AND (B.estado_exp='A' or B.estado_exp='I') AND 
	C.ced_prof=D.ced_prof AND B.sala=E.id_sala 
ORDER BY ced desc", db_conexion() );}else{
	$resultado=mysql_query("
SELECT A.*,B.*,C.*,D.*,E.*
FROM	paciente A,
	expediente B,
	historial C,
	profesional D, 
	sala E 
WHERE 	A.ced=B.ced_paciente AND
	B.ced_exp=C.dni_historial AND B.estado_exp='". $_POST["est"] ."' AND 
	C.ced_prof=D.ced_prof AND B.sala=E.id_sala 
ORDER BY ced desc", db_conexion() );
	}
	break;
}
/*************************************************
**** Seleccionar datos de la tabla patologia *****
**************************************************/
$sql_patologia = "select patologia_pac, fecha from patologia where ced='". $cedula ."'";
$res_patologia = mysql_query($sql_patologia,  db_conexion() );
$sql_habitos = "select habitos_personales from patologia where ced='". $cedula ."'";
$res_habitos = mysql_query($sql_habitos,  db_conexion() );
/************************************************/

if(mysql_num_rows($resultado)>0){
if($_POST["busqueda"]=="cedula"){
$foto = "../mod_registros/".$foto;
?>
<form action="../mod_impresion/imp_hist.php" method="post"  target="_blank">
<table width="500" align="center"  class="tabla">
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS PERSONALES</h3></td>
</tr>
<tr>
	<td class="tdatos">C&eacute;dula</td>
	<td class="dtabla">
	 <input type="hidden" name="cedula" value="<?php echo $cedula; ?>"><?php echo $cedula; ?></input></td>
</tr>
<tr>
	<td class="tdatos">Foto</td>
	<td class="dtabla"><IMG SRC="<?php echo $foto; ?>" TITLE="<?php echo $nombre; ?>" WIDTH=80	HEIGHT=100></td>
</tr>
<tr>
	<td class="tdatos">Nombres</td>
	<td class="dtabla">
	<input type="hidden" name="nombre" value="<?php echo $nombre; ?>"><?php echo $nombre; ?></input></td>
</tr>
<tr>
	<td class="tdatos">Apellidos</td>
	<td class="dtabla">
	<input type="hidden" name="apellido" value="<?php echo $apellido; ?>"><?php echo $apellido; ?></input></td>
</tr>
<tr>
	<td class="tdatos">Edad</td>
	<td class="dtabla">
	<input type="hidden" name="edad" value="<?php echo date('Y')-$ano1; ?>"><?php echo date('Y')-$ano1; ?></input></td>
</tr>
<tr>
	<td class="tdatos">Fecha Nac.</td>
	<td class="dtabla">
	<input type="hidden" name="fech_nac" value="<?php echo $dia1; echo"/"; echo $mes1; echo"/"; echo $ano1; ?>"><?php echo $dia1; echo"/"; echo $mes1; echo"/"; echo $ano1; ?></input></td>
</tr>
<tr>
	<td class="tdatos">Sexo</td>
	<td class="dtabla">
	<input type="hidden" name="sexo" value="<?php if($sexo=="M"){echo"MASCULINO";} else{echo"FEMENINO";} ?>"><?php if($sexo=="M"){echo"MASCULINO";} else{echo"FEMENINO";} ?></input></td>
</tr>
<tr>
	<td class="tdatos">Sala</td>
	<td class="dtabla">
	<input type="hidden" name="sala" value="<?php echo $sala; ?>"><?php echo $sala; ?></input></td>
</tr>
<tr>
	<td class="tdatos">Nombre del Representante</td>
	<td class="dtabla">
	<input type="hidden" name="nomrep" value="<?php echo $nomrep; ?>"><?php echo $nomrep;?></input></td>
	</tr>
<tr>
<td class="tdatos">Patologia </td>
<td class="dtabla">
<?php 
$pat = "";
$hab = "";
while($reg = mysql_fetch_array($res_patologia)){




 switch($reg["patologia_pac"]){
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
 case("OTR"):
 $patologia = strtoupper("otros");
 break;
 default:
 $patologia = "";
break;
 
 }
 if ($patologia == ""){
 
continue; 

 } else {
	$pat .= $patologia.", ";
		echo $patologia ."<br>". $reg["fecha"] ."<br><br>";	
}
}
?>
<input type="hidden" name="pat" value="<?php echo $pat;?>"></input>
</td>
</tr>
<tr>
<td class="tdatos">Habitos</td>
<td class="dtabla"><br />
<?php
$hab = "";
while($reg_habitos = mysql_fetch_array($res_habitos)){
	 for($i=0; $i<=sizeof($reg_habitos); $i++){
	 if($reg_habitos[$i] == ""){
	 	continue;
	 }
	
	 $hab .= strtoupper(str_replace(" ", ", ", $reg_habitos[$i]));
	 echo strtoupper(str_replace(" ", "<br>", $reg_habitos[$i]));	 
	 }
}

?>
<input type="hidden" name="hab" value="<?php echo $hab;?>"></input>
</td>
</tr>

<?php
if ($caso!='0'){//esta desicion se debe a que sólo muestra esta  informacion si el estatus expediente es dintinto de "NINGUNO"
?>

<tr>
	<td class="tdatos">Nombre del Profesional</td>
	<td class="dtabla">
	<input type="hidden" name="nomprf" value="<?php echo $nomprf; ?>"><?php echo $nomprf;?></input></td>
	</tr>
<tr>
	<td class="tdatos">Observaci&oacute;n</td>
	<td class="dtabla">
	<input type="hidden" name="observa" value="<?php echo $observa; ?>"><?php echo $observa;?></input></td>
	</tr>
<tr>
	<td class="tdatos">Diagnostico</td>
	<td class="dtabla">
	<input type="hidden" name="diagnostico" value="<?php echo $diagnostico; ?>"><?php echo $diagnostico;?></input></td>
</tr>
<tr>
	<td class="tdatos">Tratamiento</td>
	<td class="dtabla">
	<input type="hidden" name="tratamiento" value="<?php echo $tratamiento; ?>"><?php echo $tratamiento;?></input></td>
</tr>
<tr>
	<td class="tdatos">Receta</td>
	<td class="dtabla">
	<input type="hidden" name="receta" value="<?php echo $receta; ?>"><?php echo $receta;?></input></td>
</tr>
<tr>
	<td class="tdatos">Fecha Gen. Expedente</td>
	<td class="dtabla">
	<input type="hidden" name="fec_gen_hist" value="<?php echo $dia; echo"/"; echo $mes; echo"/"; echo $ano; ?>"><?php echo $dia; echo"/"; echo $mes; echo"/"; echo $ano; ?></input></td>
	</tr>
<tr>
	<td class="tdatos">Estatus de Expediente</td>
	<td class="dtabla">
	<input type="hidden" name="est" value="<?php if($est_exp=='A'){$caso='ACTIVO';}if($est_exp=='I'){$caso='INACTIVO';}if($est_exp=='0'){$caso='NINGUNO';}echo $caso; ?>"><?php if($est_exp=='A'){$caso='ACTIVO';}if($est_exp=='I'){$caso='INACTIVO';}if($est_exp=='0'){$caso='NINGUNO';}echo $caso; ?>
	</input></td>
</tr>
<tr>
<?php 
}//fin de caso
			echo '<tr>
						<td colspan="2" align="center" class="cdato">
						<input type="button" value="Actualizar Datos" onclick="location.href='."'".'act_his.php?cedula=cedula&cedula1='.$cedula."'".'">
						&nbsp; <input type="submit" name="imp" value="" class="imprimir"></td>
				</tr>';
?>
<?php
	}else ///genera una lista de todos los resultados que encuentra en la base de datos.
	{
?>
		<table width="500" align="center" class="tabla">
		<tr>
			<td class="tdatos">CEDULA</td>
			<td class="tdatos">NOMBRES</td>
			<td class="tdatos">APELLIDOS</td>
			<td class="tdatos">EDAD</td>
			<td class="tdatos">SALA</td>
			<td class="tdatos">ESTADO</td>
		</tr>
<?php
		while ($row=mysql_fetch_assoc($resultado)){
			if($row["sexo"]=='M'){$sexo="MASCULINO";}else{$sexo="FEMENINO";}
			$est_exp=$row["estado_exp"];
			if($est_exp=='I'){$caso='INACTIVO';}if($est_exp=='A'){$caso='ACTIVO';}if($est_exp=='0'){$caso='NINGUNO';}
			$edad=(date('Y')-(substr($row["fec_nac"],0,4)));//calcula la edad automaticamente	
			echo "<tr><td class=\"tdatos\"><a href=\"bus_his.php?busqueda=cedula&ced=".$row["ced"]."\">".$row["ced"]."</a></td><td class=\"cdato\">".$row["nombre"]."</td><td class=\"cdato\">".$row["apellido"]."</td><td class=\"cdato\">".$edad."</td><td class=\"cdato\">".$row["denominacion"]."</td><td class=\"cdato\">".$caso."</td>";
		}
	}
?>
</tr>
</table>
<?php			
		}else///mensaje de error cuando no encuentra ningun registro en la base de datos
		{
			cuadro_error("paciente: <b>".$_POST["nom"]."</b> <b>".$_POST["ape"]."</b> No Registrad@  <b><a href=../mod_registros/reg_est.php target=\"_self\">Registrar?</a></b>"); ///colocar un enlace para registrar a la persona
		}
}		
echo "<br>";
require("../theme/footer_inicio.php");
?>
