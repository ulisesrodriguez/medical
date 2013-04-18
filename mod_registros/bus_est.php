<?php
require("../theme/header_inicio.php");
?>
<br />
<div class="titulo">Consulta del Paciente</div><br /><br />
<div id="centercontent">
<div align="center">
<table>
<td>
	<form action="bus_est.php" method="post">
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
<form action="bus_est.php" method="post">
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
	<form action="bus_est.php" method="post">
		<input type="hidden" name="busqueda" value="sala">
		<table class="tabla">
		<tr>
			<td colspan="2" align="center">Consulta por Sala Medica</td>
		</tr>
		<tr>
		<td>
			<select name="sala">
			<option value="">Seleccione</option>
			<?php
				$result2=mysql_query("select * from sala",db_conexion());
				while($row2=mysql_fetch_assoc($result2)){
					if ($row2["id_sala"]==$_POST["sala"]){ $slt="selected ";}else{ $slt="";}
					echo "<option $slt value=\"".$row2["id_sala"]."\">".$row2["denominacion"]."</option>\n";
				}
			?>
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
<div align="center">
<?php




if( isset( $_POST["busqueda"] ) ){

	switch($_POST["busqueda"]){
		
		case'nombre':
		$resultado=mysql_query("select a.*,b.*,c.* from paciente a, expediente b, sala c where a.nombre like '%".strtoupper($_POST["nom"])."%' and a.ced=b.ced_paciente and b.sala=c.id_sala order by ced desc",db_conexion());
		break;
		case'apellido':
		$resultado=mysql_query("select a.*,b.*,c.* from paciente a, expediente b, sala c where a.apellido like '%".strtoupper($_POST["ape"])."%' and a.ced=b.ced_paciente and b.sala=c.id_sala order by ced desc",db_conexion());
		break;
		case'sala':
		$resultado=mysql_query("select a.*,b.*,c.* from paciente a, expediente b, sala c where a.ced=b.ced_paciente and b.sala='".quitar($_POST["sala"])."' and b.sala=c.id_sala order by ced desc",db_conexion());
		break;
	}
	
?>
		<table width="500" align="center" class="tabla">
		<tr>
			<td class="tdatos">CEDULA</td>
			<td class="tdatos">NOMBRES</td>
			<td class="tdatos">APELLIDOS</td>
			<td class="tdatos">EDAD</td>
			<td class="tdatos">SALA</td>			
		</tr>
<?php
		while ($row=mysql_fetch_assoc($resultado)){
			if($row["sexo"]=='M'){$sexo="MASCULINO";}else{$sexo="FEMENINO";}
			$edad=(date('Y')-(substr($row["fec_nac"],0,4)));//calcula la edad automaticamente	
			echo "<tr><td class=\"tdatos\"><a href=\"bus_est.php?busqueda=cedula&ced=".$row["ced"]."\">".$row["ced"]."</a></td><td class=\"cdato\">".$row["nombre"]."</td><td class=\"cdato\">".$row["apellido"]."</td><td class=\"cdato\">".$edad."</td><td class=\"cdato\">".$row["denominacion"]."</td>";
		$vehiculo="";
			}
		}
?>
</table>

</form>
<?php			





















if( isset( $_GET["busqueda"] ) ){

	
$resultado=mysql_query("select a.*,b.*,c.* from paciente a, expediente b, sala c where a.ced='".quitar($_GET["ced"])."' and a.ced=b.ced_paciente and b.sala=c.id_sala ",db_conexion());

	if(mysql_num_rows($resultado) == 1){
	$cedula=mysql_result($resultado,0,"ced");
	$id_pac=mysql_result($resultado,0,"id_paciente");
	$id_exp=mysql_result($resultado,0,"dni_exp");
	$est_exp=mysql_result($resultado,0,"estado_exp");
	$nombre=mysql_result($resultado,0,"nombre");
	$apellido=mysql_result($resultado,0,"apellido");
	$sexo=mysql_result($resultado,0,"sexo");
	$nomrep=mysql_result($resultado,0,"nombre_representante");
	$telefono=mysql_result($resultado,0,"telefono");
	$foto=mysql_result($resultado,0,"foto");
	$sala=mysql_result($resultado,0,"denominacion");
	$direccion=mysql_result($resultado,0,"direccion");
	$emergencia=mysql_result($resultado,0,"emergencia");
	$grusan=mysql_result($resultado,0,"grusan");
	$vih=mysql_result($resultado,0,"vih");
	$peso=mysql_result($resultado,0,"peso");
	$talla=mysql_result($resultado,0,"talla");
	$alergico=mysql_result($resultado,0,"alergico");
	$medact=mysql_result($resultado,0,"med_act");
	$enfermedad=mysql_result($resultado,0,"enf_act");
	$dia1=substr(mysql_result($resultado,0,"fec_nac"),8,2);
	$mes1=substr(mysql_result($resultado,0,"fec_nac"),5,2);
	$ano1=substr(mysql_result($resultado,0,"fec_nac"),0,4);
				
	}	

if(mysql_num_rows($resultado)>0){	
	
?>

<form action="../mod_impresion/imp_reg.php" method="post" id="form">
<br />
<table width="500" align="center"  class="tabla">
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS PERSONALES</h3></td>
</tr>

<tr>
	<td class="tdatos">C&eacute;dula:</td>
	<td class="dtabla">
	 <input type="hidden" name="cedula" value="<?php echo $cedula; ?>"><?php echo $cedula; ?></input></td>
</tr>

<tr>
	<td class="tdatos">Foto</td>
	<td class="dtabla"><IMG SRC="<?php echo $foto; ?>" TITLE="<?php echo $nombre; ?>" WIDTH=80	HEIGHT=100></td>
</tr>

<tr>
	<td class="tdatos">Nombres:</td>
	<td class="dtabla">
	<input type="hidden" name="nombre" value="<?php echo $nombre; ?>"><?php echo $nombre; ?></input></td>
</tr>

<tr>
	<td class="tdatos">Apellidos:</td>
	<td class="dtabla">
	<input type="hidden" name="apellido" value="<?php echo $apellido; ?>"><?php echo $apellido; ?></input></td>
</tr>

<tr>
	<td class="tdatos">Edad:</td>
	<td class="dtabla">
	<input type="hidden" name="edad" value="<?php echo date('Y')-$ano1; ?>"><?php echo date('Y')-$ano1; ?></input></td>
</tr>

<tr>
	<td class="tdatos">Fecha Nac:</td>
	<td class="dtabla">
	<input type="hidden" name="fech_nac" value="<?php echo $dia1; echo"/"; echo $mes1; echo"/"; echo $ano1; ?>"><?php echo $dia1; echo"/"; echo $mes1; echo"/"; echo $ano1; ?></input></td>
</tr>

<tr>
	<td class="tdatos">Sexo:</td>
	<td class="dtabla">
	<input type="hidden" name="sexo" value="<?php if($sexo=="M"){echo"MASCULINO";} else{echo"FEMENINO";} ?>"><?php if($sexo=="M"){echo"MASCULINO";} else{echo"FEMENINO";} ?></input></td>
</tr>

<tr>
	<td class="tdatos">Sala:</td>
	<td class="dtabla">
	<input type="hidden" name="sala" value="<?php echo $sala; ?>"><?php echo $sala; ?></input></td>
</tr>

<tr>
	<td class="tdatos">Tel&eacute;fono:</td>
	<td class="dtabla">
	<input type="hidden" name="telefono" value="<?php echo $telefono; ?>"><?php echo $telefono; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Nombre del Representante:</td>
	<td class="dtabla">
	<input type="hidden" name="nomrep" value="<?php echo $nomrep; ?>"><?php echo $nomrep;?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Direcci&oacute;n:</td>
	<td class="dtabla">
	<input type="hidden" name="direccion" value="<?php echo $direccion ?>"><?php echo $direccion; ?>
	</input></tr>
</tr>

<tr>
	<td class="tdatos">Emergencia:</td>
	<td class="dtabla">
	<input type="hidden" name="emergencia" value="<?php echo $emergencia; ?>"><?php echo $emergencia; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Grupo Sanguineo:</td>
	<td class="dtabla">
	<?php 
	switch($grusan)
	{
	case("AME"):
	$grusan="A RH-";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
    case("AMA"):
    $grusan="A RH+";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	case("ABME"):
	$grusan="AB RH-";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	case("ABMA"):
	$grusan="AB RH+";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	case("BME"):
	$grusan="B RH-";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	case("BMA"):
	$grusan="B RH+";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	case("OME"):
	$grusan= "O RH-";
	?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	case("OMA"):
    $grusan="O RH+";
    ?>
	<input type="hidden" name="grusan" value="<?php echo $grusan; ?>"><?php echo $grusan; ?></input><?php
	break;
	}
	?></td>
</tr>

<tr>
	<td class="tdatos">VIH:</td>
	<td class="dtabla">
	<input type="hidden" name="vih" value="<?php if($vih=="S"){echo"SI";} else{echo"NO";} ?>"><?php if($vih=="S"){echo"SI";} else{echo"NO";} ?></input></td>
</tr>

<tr>
	<td class="tdatos">Alergico:</td>
	<td class="dtabla">
	<input type="hidden" name="alergico" value="<?php echo $alergico; ?>"><?php echo $alergico; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Peso:</td>
	<td class="dtabla">
	<input type="hidden" name="peso" value="<?php echo $peso; ?>"><?php echo $peso; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Talla:</td>
	<td class="dtabla">
	<input type="hidden" name="talla" value="<?php echo $talla; ?>"><?php echo $talla; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Medicamento Que toma Actualmente:</td>
	<td class="dtabla">
	<input type="hidden" name="medact" value="<?php echo $medact; ?>"><?php echo $medact; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Enfermedad Que Tiene:</td>
	<td class="dtabla">
	<input type="hidden" name="enfermedad" value="<?php echo $enfermedad; ?>"><?php echo $enfermedad; ?>
	</input></td>
</tr>

<tr>
	<td class="tdatos">Estatus de Expediente</td>
	<td class="dtabla">
	<input type="hidden" name="est" value="<?php if($est_exp=='A'){$caso='ACTIVO';}if($est_exp=='I'){$caso='INACTIVO';}if($est_exp=='0'){$caso='NINGUNO';}echo $caso; ?>"><?php if($est_exp=='A'){$caso='ACTIVO';}if($est_exp=='I'){$caso='INACTIVO';}if($est_exp=='0'){$caso='NINGUNO';}echo $caso; ?>
	</input></td>
</tr>

<input type="hidden" name="cedula1" value="<?php echo $cedula ?>" />

<?php 
			echo '<tr>
				<td colspan="2" align="center" class="cdato">
<input type="button" value="Actualizar Datos" onclick="javascript: this.form.action=\'act_est.php\'; this.form.submit();">
&nbsp; <input type="submit" name="imp"  value="" class="imprimir"></td>

				</tr>';
?>
</td>
</table>
</form>
<?php
}
}
echo "<br><br>";
require("../theme/footer_inicio.php");
?>
