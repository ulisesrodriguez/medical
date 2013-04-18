<?php
require("../theme/header_inicio.php");
$bandera=null;
$existe=null;
?>
<br />
<div class="titulo">Actualizaci&oacute;n del Historial del Paciente</div><br /><br />
<?php
if ( isset( $_POST["acc"] ) and strtolower($_POST["acc"])=="registrar"){// CUANDO LA ACCION SEA "registrar" ENTRA EN LA CONDICION
//VALIDACIONES DE LOS DATOS ENVIADOS
if ($_POST["cedpro"]=="" or $_POST["cedpac"]=="" or $_POST["obser"]==""){
	cuadro_error("Debe ingresar la cédulas del profesional y del paciente con su respectiva observación");
	}else{

$sql="update historial set ced_prof='".$_POST["cedpro"]."',observacion='".$_POST["obser"]."',diagnostico='".$_POST["diagnostico"]."',tratamiento='".$_POST["tratamiento"]."',fec_gen_hist='".$_POST["ano"]."-".$_POST["mes"]."-".$_POST["dia"]."',receta='".$_POST["receta"]."',ced_pac='".$_POST["cedpac"]."' where dni_historial='".$_POST["codexp"]."'";
$sql2="update expediente set ced_exp='".$_POST["codexp"]."',fec_gen_exp='".$_POST["ano1"]."-".$_POST["mes1"]."-".$_POST["dia1"]."',estado_exp='".$_POST["estado"]."' where ced_paciente='".$_POST["cedpac"]."' ";
//Inserta los datos a la tabla patologia
// patologia insert into patologia values(NULL,'". $_POST["cedpac"]., 'una','dos',now())
$sql3="insert into patologia (id, ced, patologia_pac, fecha) values(NULL,'".$_POST["cedpac"] ."','" .$_POST["patologia"] . "',now())";

		if(mysql_query($sql, db_conexion() ) && mysql_query($sql2, db_conexion() ) && mysql_query($sql3,  db_conexion() )){
	 				echo "<br>";	
						cuadro_mensaje("Historial Actualizado Correctamente...");
					echo "<br><br><br><br>";
					require("../theme/footer_inicio.php");
			exit;
				}
				 else {
				 	
				 	echo "Error: ".mysql_error();
				 	
				 }
	}
}
if(!$bandera){
?>
<form action="act_his.php" method="post">
<table align="center" class="tabla">
<tr>
	<td colspan="2" align="center">Ingrese Cedula del Paciente</td>
	<tr>
	<td><input name="cedula1" type="text" value="" size="20"></td>
	<td><input type="submit" value="Buscar"></td>
	</tr>
</tr>
</table>
</form>
<?php
}//fin de $bandera
if( isset( $_POST["cedula1"] ) and $_POST["cedula1"]!=""){
$bandera=1;//este es una bandera para que luego de la busqueda no vuelva a pedir la cedula del paciente
//busca en la base de datos 
$result3=mysql_query("select a.*,b.* from historial a, expediente b where a.ced_pac='".quitar($_POST["cedula1"])."' and a.ced_pac=b.ced_paciente ", db_conexion() );
	if(mysql_num_rows($result3) == 1){
	$cedulpac=mysql_result($result3,0,"ced_pac");	//guarda la cedula del paciente que esta en la tabla de historial
	$cedulpro=mysql_result($result3,0,"ced_prof"); //igualmente con la del profesional
	$codexp=mysql_result($result3,0,"dni_historial");
	$dia=substr(mysql_result($result3,0,"fec_gen_hist"),8,2);
	$mes=substr(mysql_result($result3,0,"fec_gen_hist"),5,2);
	$ano=substr(mysql_result($result3,0,"fec_gen_hist"),0,4);
	$obser=mysql_result($result3,0,"observacion");
	$estado=mysql_result($result3,0,"estado_exp");
	$diagnostico=mysql_result($result3,0,"diagnostico");
	$tratamiento=mysql_result($result3,0,"tratamiento");
	$receta=mysql_result($result3,0,"receta");

	$existe=1;//2da bandera, osea los datos existen!
	}else{
		echo "<br>";
		cuadro_error("El paciente no tiene ningun hitorial registrado");
		echo "<br><br>";
		require("../theme/footer_inicio.php");
		exit;
		
	}
}
if($existe==1 or  isset( $_POST["existe"] ) and $_POST["existe"]==1){
///COMO YA ENCONTRO EL REGISTRO DEL PACIENTE EN LA TABLA DEL HISTORIAL CARGA EL FORMULARIO
if($cedulpro==""){$cedulpro=$_POST["cedpro"];}
if($cedulpac==""){$cedulpac=$_POST["cedpac"];}
if($codexp==""){$codexp=$_POST["codexp"];}
if($existe==""){$existe=$_POST["existe"];}
if($estado==""){$estado=$_POST["estado"];}
if($obser==""){$obser=$_POST["obser"];}
if($dia==""){$dia= date('d');}
if($mes==""){$mes= date('m');}
if($ano==""){$ano= date('Y');}
if($diagnostico==""){$diagnostico=$_POST["diagnostico"];}
if($tratamiento==""){$tratamiento=$_POST["tratamiento"];}
if($receta==""){$receta=$_POST["receta"];}

?>
<br />
<form name="registro" action="act_his.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="existe" value="<?php echo $existe;?>">
<table width="650" align="center" class="tabla">
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS HISTORIALES DEL PACIENTE</h3></td>
</tr>
<tr>
	<td class="tdatos">C&oacute;digo Expediente</td>
	<td class="dtabla"><input type="text" name="codexp" value="<?php echo $codexp; ?>" readonly size="12" /> Que ser&aacute; modificado</td>
</tr>
<tr>
	<td class="tdatos">C&eacute;dula del Profesional</td>
	<td class="dtabla"><input type="text" name="cedpro" value="<?php echo $cedulpro; ?>" onchange="this.form.submit()" size="12" /></td>
</tr>
<?php
///cuando ya esta registrado el prof
if( $cedulpro!=""){
$result=mysql_query("select * from profesional where ced_prof='".quitar($cedulpro)."' ", db_conexion() );
if(mysql_num_rows($result) == 1){
$nombre=mysql_result($result,0,"nombre_apellido");
$tipoprof=mysql_result($result,0,"tipo_prof");
?>
	<td class="tdatos">Nombre del Profesional</td>
	<td class="dtabla"><input type="text" name="cedest" value='<?php echo $nombre; ?>' size="12" /></td>
      </tr>
     <tr>
	<td class="tdatos">Tipo de Profesi&oacute;n</td>
	<td class="dtabla"><input type="text" name="cedest" value='<?php echo $tipoprof; ?>' size="12" /></td>
      </tr>
<?php 
	}else{
?>
     <tr>
	<td class="cuadro_error" colspan="2" align="center">Profesional no registrado, verifique la c&eacute;dula</td>
      </tr>
<?php
	}
}
?>
<tr>
	<td class="tdatos">C&eacute;dula del Paciente</td>
	<td class="dtabla"><input type="text" name="cedpac" value="<?php echo $cedulpac ?>" onchange="this.form.submit()" size="12" /></td>
</tr>
<?php
if($cedulpac!=""){
$result=mysql_query("select a.*,b.* from paciente a, expediente b where a.ced=b.ced_paciente and b.ced_paciente='".quitar($cedulpac)."' ", db_conexion() );
$cmd_patologia = "select * from patologia where ced='".$cedulpac."'";
$cmd_habitos = "select * from patologia where ced='".$cedulpac."'";
$res_patologia = mysql_query($cmd_patologia,  db_conexion() );
$res_habitos = mysql_query($cmd_habitos,  db_conexion() );
if(mysql_num_rows($result) == 1){
$cedula=mysql_result($result,0,"ced");
$id_pac=mysql_result($result,0,"id_paciente");
$id_exp=mysql_result($result,0,"dni_exp");
$nombre=mysql_result($result,0,"nombre");
$apellido=mysql_result($result,0,"apellido");
$sexo=mysql_result($result,0,"sexo");if($sexo=="M"){$sexo="MASCULINO";} else{$sexo="FEMENINO";}
$nomrep=mysql_result($result,0,"nombre_representante");
$foto=mysql_result($result,0,"foto");
$sala=mysql_result($result,0,"sala");
$dia1=substr(mysql_result($result,0,"fec_nac"),8,2);
$mes1=substr(mysql_result($result,0,"fec_nac"),5,2);
$ano1=substr(mysql_result($result,0,"fec_nac"),0,4);

switch($sala){
		case(1):
		$sala="EMERGENCIA";
		break;
		case(2):
		$sala="SALA-A";
		break;
		case(3):
		$sala= "LABORATARIO";
		break;
		case(4):
		$sala = "RAYOS-X";
		break;
		default:
		$sala="La sala no existe";
		break;
		}
$foto = "../mod_registros/".$foto;
?>
<tr>
	<td class="tdatos">Foto</td>
	<td class="dtabla"><IMG SRC='<?php echo $foto; ?>' TITLE='<?php echo $foto; ?> '  WIDTH=80	HEIGHT=100></td>
</tr>
<tr>
	<td class="tdatos">Nombres</td>
	<td class="dtabla"><input type="text" name="nombre" value='<?php echo $nombre; ?>' size="40" readonly/></td>
</tr>
<tr>
	<td class="tdatos">Apellidos</td>
	<td class="dtabla"><input type="text" name="apellido" value='<?php echo $apellido; ?>' size="40" readonly/></td>
</tr>
<tr>
	<td  class="tdatos">Fecha de Nacimiento</td>
	<td class="dtabla"><input type="text" name="dia1" value='<?php echo $dia1; ?>' size="1" readonly/>/<input type="text" name="mes1" value='<?php echo $mes1; ?>' size="1" readonly/>/<input type="text" name="ano1" value='<?php echo $ano1; ?>' size="2" readonly/>d&iacute;a/mes/a&ntilde;o</td>
<?php 
echo '</tr>
<tr>
	<td class="tdatos">Sexo</td>
	<td class="dtabla"><input type="text" name="sexo" value='. $sexo.' size="15" readonly /></td>
</tr>
<tr>
	<td class="tdatos">Nombre del Representante</td>
	<td class="dtabla"><input type="text" name="nomrep" value='.$nomrep.' size="40" readonly/></td>
</tr>
<tr>
	<td class="tdatos">Sala</td>
	<td class="dtabla"><input type="text" name="sala" value='.$sala.' size="20" readonly/></td>
</tr>';
 
	}else{
?>
     <tr>
		<td class="cuadro_error" colspan="2" align="center">Paciente no registrado, verifique la c&eacute;dula</td>
     </tr>
<?php
	}
}
?>
<tr>
	<td  class="tdatos">Creaci&oacute;n del Expediente</td>
	<td class="dtabla"><input type="text" name="dia" value="<?php echo $dia; ?>" size="1" />/<input type="text" name="mes" value="<?php echo $mes; ?>" size="1" />/<input type="text" name="ano" value="<?php echo $ano; ?>" size="2" />d&iacute;a/mes/a&ntilde;o</td>
</tr>
<tr>
	<td class="tdatos">Estado</td>
	<td class="dtabla">
		<select name="estado">
			<option value="A" <?php if ($estado=="A") echo "selected" ?>>ACTIVO</option>
			<option value="I" <?php if ($estado=="I") echo "selected" ?>>INACTIVO</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Patologia Personal</td>
	<td class="dtabla">
	<select name="patologia">
		<option value="">Seleccione</option>
		<option value="ASM" <?php if ($_POST["patologia"]=="ASM") echo "selected" ?>>ASMA</option>
		<option value="NEU" <?php if ($_POST["patologia"]=="NEU") echo "selected" ?>>NEUMONIA</option>
		<option value="CAR" <?php if ($_POST["patologia"]=="CAR") echo "selected" ?>>CARDIOPATIA</option>
		<option value="HIP" <?php if ($_POST["patologia"]=="HIP") echo "selected" ?>>HIPERTENCION</option>
		<option value="VAR" <?php if ($_POST["patologia"]=="VAR") echo "selected" ?>>VARICES</option>
		<option value="DES" <?php if ($_POST["patologia"]=="DES") echo "selected" ?>>DESNUTRICION</option>
		<option value="DIA" <?php if ($_POST["patologia"]=="DIA") echo "selected" ?>>DIABETES</option>
		<option value="ENF" <?php if ($_POST["patologia"]=="ENF") echo "selected" ?>>ENF.RENAL</option>
		<option value="CAN" <?php if ($_POST["patologia"]=="CAN") echo "selected" ?>>CANCER</option>
    	<option value="TUM" <?php if ($_POST["patologia"]=="TUM") echo "selected" ?>>TUMOR MAMARIO</option>
		<option value="DEN" <?php if ($_POST["patologia"]=="DEN") echo "selected" ?>>DENGUE</option>
		<option value="OBE" <?php if ($_POST["patologia"]=="OBE") echo "selected" ?>>OBECIDAD</option>
		<option value="ENF" <?php if ($_POST["patologia"]=="ENF") echo "selected" ?>>ENF.T.S</option>
		<option value="ACV" <?php if ($_POST["patologia"]=="ACV") echo "selected" ?>>ACV</option>
		<option value="OTR" <?php if ($_POST["patologia"]=="OTR") echo "selected" ?>>OTROS</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS DE PATOLOGIA</h3></td>
</tr>
<tr>
	<td class="dtabla" colspan="2" align="center">
<table class="tabla">
	  
	   <?php 
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
echo "<tr>";
echo "<td class='dtabla'>". $patologia ."</td>".
     "<td class='dtabla'>". $reg["fecha"]."</td>";	 
echo "</tr>";
 }
}  
 
 ?>
	  
	  </table>
		
	
	</td>
</tr>
 
 <tr>
	<td class="tdatos" colspan="2" align="center"><h3>HABITOS PERONALES</h3></td>
</tr>
<tr>
	<td class="tabla" colspan="2" align="center">
	  <table>
	  
	   <?php 
while($reg_habitos = mysql_fetch_array($res_habitos)){
 echo "<tr>";
echo "<td class='dtabla'>". str_replace(" ", "<br>", strtoupper($reg_habitos["habitos_personales"])) ."</td>";
    
echo "</tr>";
 
 }  
 
 ?>
	  
	  </table>
		
	
	</td>
</tr>
<tr>
	<td class="tdatos">Observaciones</td>
	<td class="dtabla"><textarea rows="4" name="obser" cols="40"><?php echo $obser; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Diagnostico</td>
	<td class="dtabla"><textarea rows="4" name="diagnostico" cols="40"><?php echo $diagnostico; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Tratamiento</td>
	<td class="dtabla"><textarea rows="4" name="tratamiento" cols="40"><?php echo $tratamiento; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Receta</td>
	<td class="dtabla"><textarea rows="4" name="receta" cols="40"><?php echo $receta; ?></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="acc" value="Registrar"></td>
</tr>
</table>
</form>
<?php
}//fin de existe!
 echo "<br><br><br><br>";
require("../theme/footer_inicio.php");
?>
