<?php
require("../theme/header_inicio.php");

//BUSCA EN LOS REGISTROS DE IHISTORIALES CUAL ES EL MAXIMO NUMERO O EL ULTIMO MAYOR
$max="select max(dni_historial) as maxid from historial";
$rs=mysql_query($max, db_conexion() );
	if(mysql_num_rows($rs)){
	$codexp=mysql_result($rs,0,"maxid")+1; //SE LE SUMA 1 PARA QUE SEA EL REGISTRO CORRELATIVO 
	}else{$codexp=1;}//SINO EXISTE LE AGREGA 1 (EL PRIMERO) SOLO SE CUMPLE UNA SOLA VEZ
if ( isset($_POST["acc"]) and strtolower($_POST["acc"])=="registrar"){// CUANDO LA ACCION SEA "registrar" ENTRA EN LA CONDICION
//VALIDACIONES DE LOS DATOS ENVIADOS
if ($_POST["cedpro"]=="" or $_POST["cedpac"]=="" or $_POST["obser"]==""){
	cuadro_error("Debe ingresar la cédulas del profesional y del paciente con su respectiva observación");
	}else{
$sql="insert into historial(ced_pac,ced_prof,fec_gen_hist,observacion,diagnostico,tratamiento,receta) values('".$_POST["cedpac"]."','".$_POST["cedpro"]."','".$_POST["ano1"]."-".$_POST["mes1"]."-".$_POST["dia1"]."','".$_POST["obser"]."','".$_POST["diagnostico"]."','".$_POST["tratamiento"]."','".$_POST["receta"]."') ";
$sql2="update expediente set ced_exp='".$_POST["codexp"]."',fec_gen_exp='".$_POST["ano1"]."-".$_POST["mes1"]."-".$_POST["dia1"]."',estado_exp='". isset( $_POST["estado"] ) and $_POST["estado"] ."' where ced_paciente='".$_POST["cedpac"]."' ";

$habitos_per = "";
$hd =  isset( $_POST ["habitos"] ) and $_POST ["habitos"] ;
for($i=0; $i<=sizeof($hd); $i++){
	$habitos_per .= $hd[$i]." ";
	}
//Inserta los datos a la tabla patologia
$sql3="insert into patologia values( null,'".$_POST["cedpac"] ."','" . $_POST["patologia"]  . "','". $habitos_per . "', now() );";


		if(mysql_query($sql, db_conexion() ) && mysql_query($sql2, db_conexion() ) && db_query( $sql3 ) ){
	 				cuadro_error("Historial Registrado Correctamente...");
					echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
				}
				 else {
				 	
				 	//echo "Error: ".mysql_error();
				 	
				 }

	}
}


?>
<br />

<div class="titulo">Historial del Paciente</div><br /><br />
<form name="registro" action="reg_his.php" method="post" enctype="multipart/form-data">
<table width="600" align="center" class="tabla">
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS HISTORIALES DEL PACIENTE</h3></td>
</tr>
<tr>
	<td class="tdatos">C&oacute;digo Expediente</td>
	<td class="dtabla"><input type="text" name="codexp" value="<?php echo $codexp; ?>" readonly size="12" /></td>
</tr>
<tr>
	<td class="tdatos">C&eacute;dula del Profesional</td>
	<td class="dtabla"><input type="text" name="cedpro" value="<?php if( isset( $_POST["cedpro"] ) )echo $_POST["cedpro"]; ?>" onchange="this.form.submit()" size="12" /></td>
</tr>
<?php
if( isset($_POST["cedpro"]) and $_POST["cedpro"]!=""){
$result=mysql_query("select * from profesional where ced_prof='".quitar($_POST["cedpro"])."' ", db_conexion() );
if(mysql_num_rows($result) == 1){
$nombre=mysql_result($result,0,"nombre_apellido");
$tipoprof=mysql_result($result,0,"tipo_prof");
?>
<tr>
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
	<td class="dtabla"><input type="text" name="cedpac" value="<?php if( isset( $_POST["cedpac"] ) ) echo $_POST["cedpac"]; ?>" onchange="this.form.submit()" size="12" /></td>
</tr>
<?php
if( isset($_POST["cedpac"]) and $_POST["cedpac"]!=""){
$result=mysql_query("select a.*,b.* from paciente a, expediente b where a.ced=b.ced_paciente and b.ced_paciente='".quitar($_POST["cedpac"])."' ", db_conexion() );
if(mysql_num_rows($result) == 1){
$cedula=mysql_result($result,0,"ced");
$id_pac=mysql_result($result,0,"id_paciente");
$id_exp=mysql_result($result,0,"dni_exp");
$foto=mysql_result($result,0,"foto");
$nombre=mysql_result($result,0,"nombre");
$apellido=mysql_result($result,0,"apellido");
$sexo=mysql_result($result,0,"sexo");if($sexo=="M"){$sexo="MASCULINO";} else{$sexo="FEMENINO";}
$nomrep=mysql_result($result,0,"nombre_representante");
$telefono=mysql_result($result,0,"telefono");
$sala=mysql_result($result,0,"sala");
$alergico=mysql_result($result,0,"alergico");
$medact=mysql_result($result,0,"med_act");
$direccion=mysql_result($result,0,"direccion");
$dia1=substr(mysql_result($result,0,"fec_nac"),8,2);
$mes1=substr(mysql_result($result,0,"fec_nac"),5,2);
$ano1=substr(mysql_result($result,0,"fec_nac"),0,4);
/*******************************************************
***************** Seleccion de salas *******************
*******************************************************/
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
echo '<tr>
	<td class="tdatos">Foto</td>
	<td><IMG SRC='.$foto.' TITLE='.$foto. '  WIDTH=80	HEIGHT=100></td>
</tr>
<tr>
	<td class="tdatos">Nombres</td>
	<td><input type="text" name="nombre" value='.$nombre.' size="40" readonly/></td>
</tr>
<tr>
	<td class="tdatos">Apellidos</td>
	<td><input type="text" name="apellido" value='.$apellido.' size="40" readonly/></td>
</tr>
<tr>
	<td  class="tdatos">Fecha de Nacimiento</td>
	<td><input type="text" name="dia1" value='.$dia1.' size="1" readonly/>/<input type="text" name="mes1" value='.$mes1.' size="1" readonly/>/<input type="text" name="ano1" value='.$ano1.' size="2" readonly/>dia/mes/año</td>
</tr>
<tr>
	<td class="tdatos">Sexo</td>
	<td><input type="text" name="sexo" value='. $sexo.' size="15" readonly /></td>
</tr>
<tr>
	<td class="tdatos">Nombre del Representante</td>
	<td><input type="text" name="nomrep" value='.$nomrep.' size="40" readonly/></td>
</tr>
<tr>
	<td class="tdatos">Telefonos</td>
	<td><input type="text" name="telefono" value='.$telefono.' size="20" readonly /></td>
</tr>
<tr>
	<td class="tdatos">Sala</td>
	<td><input type="text" name="sala" value='.$sala.' size="20" readonly/></td>
</tr>
<tr>
	<td class="tdatos">Alergico</td>
	<td><input type="text" name="alergico" value='.$alergico.' size="40" readonly/></td>
</tr>
<tr>
	<td class="tdatos">Medicamento Que Toma Actualmente</td>
	<td><input type="text" name="medact" value='.$medact.' size="40" readonly/></td>
</tr>
     ';
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
	<td class="dtabla"><input type="text" name="dia1" value="<?php echo date('d'); ?>" readonly size="1" />/<input type="text" name="mes1" value="<?php echo date('m'); ?>" readonly size="1" />/<input type="text" name="ano1" value="<?php echo date('Y'); ?>" readonly size="2" />d&iacute;a/mes/a&ntilde;o</td>
</tr>
<tr>
	<td class="tdatos">Estado</td>
	<td class="dtabla">
		<select name="estado">
			<option value="A" <?php if ( isset( $_POST["estado"] ) and $_POST["estado"] =="A") echo "selected" ?>>ACTIVO</option>
			<option value="I" <?php if ( isset( $_POST["estado"] ) and $_POST["estado"] =="I") echo "selected" ?>>INACTIVO</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Patologia Personal</td>
	<td class="dtabla">
	<select name="patologia">
		<option value="">Seleccione</option>
		<option value="ASM" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="ASM") echo "selected" ?>>ASMA</option>
		<option value="NEU" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="NEU") echo "selected" ?>>NEUMONIA</option>
		<option value="CAR" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="CAR") echo "selected" ?>>CARDIOPATIA</option>
		<option value="HIP" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="HIP") echo "selected" ?>>HIPERTENCION</option>
		<option value="VAR" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="VAR") echo "selected" ?>>VARICES</option>
		<option value="DES" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="DES") echo "selected" ?>>DESNUTRICION</option>
		<option value="DIA" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="DIA") echo "selected" ?>>DIABETES</option>
		<option value="ENF" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="ENF") echo "selected" ?>>ENF.RENAL</option>
		<option value="CAN" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="CAN") echo "selected" ?>>CANCER</option>
    	<option value="TUM" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="TUM") echo "selected" ?>>TUMOR MAMARIO</option>
		<option value="DEN" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="DEN") echo "selected" ?>>DENGUE</option>
		<option value="OBE" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="OBE") echo "selected" ?>>OBECIDAD</option>
		<option value="ENF" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="ENF") echo "selected" ?>>ENF.T.S</option>
		<option value="ACV" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="ACV") echo "selected" ?>>ACV</option>
		<option value="OTR" <?php if ( isset( $_POST["patologia"] ) and $_POST["patologia"] =="OTR") echo "selected" ?>>OTROS</option>
		</select>
	</td>
</tr>
<!--<td>
	<td class="tdatos">Habitos Personales</td>
</td> -->
<tr>
<td class="tdatos"> Habitos Personales </td>
<td class="dtabla">
<input type="checkbox" name="habitos[]" value="fuma" <?php if ( isset( $_POST ["habitos"] ) and $_POST ["habitos"] =="fuma") echo "selected" ?> />FUMA
  <input type="checkbox" name="habitos[]" value="bebe" <?php if ( isset( $_POST ["habitos"] ) and $_POST ["habitos"] =="bebe") echo "selected" ?> />BEBE
  <br>  <input type="checkbox" name="habitos[]" value="droga" <?php if ( isset( $_POST ["habitos"] ) and $_POST ["habitos"] =="droga") echo "selected" ?>/>DROGA
  <input type="checkbox" name="habitos[]" value="deporte" <?php if ( isset( $_POST ["habitos"] ) and $_POST ["habitos"] =="deporte") echo "selected" ?>/>DEPORTE
  </td>
</tr>
<tr>
	<td class="tdatos">Observaciones</td>
	<td class="dtabla"><textarea rows="4" name="obser" cols="40"><?php if( isset( $_POST ["obser"] ) ) echo $_POST["obser"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Diagnostico</td>
	<td class="dtabla"><textarea rows="4" name="diagnostico" cols="40"><?php if( isset( $_POST ["diagnostico"] ) ) echo $_POST["diagnostico"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Tratamiento</td>
	<td class="dtabla"><textarea rows="4" name="tratamiento" cols="40"><?php if( isset( $_POST ["tratamiento"] ) ) echo $_POST["tratamiento"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Receta</td>
	<td class="dtabla"><textarea rows="4" name="receta" cols="40"><?php if( isset( $_POST ["receta"] ) ) echo $_POST["receta"]; ?></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="acc" value="Registrar"></td>
</tr>
</table>
</form>
<?php
require("../theme/footer_inicio.php");
?>
