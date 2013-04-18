<?php
require("../theme/header_inicio.php");


if( isset( $_POST["del"] ) and strtolower($_POST["del"]) == "eliminar" ){
	
	$sqldelexp = "delete from expediente where ced_paciente='".(int)$_POST["cedula"]."'";
	$sqldelpac = "delete from paciente where ced='".(int)$_POST["cedula"]."'";
	$sqldelhis = "delete from historial where ced_pac='".(int)$_POST["cedula"]."'";
	$sqldelpat = "delete from patologia where ced='".(int)$_POST["cedula"]."'";
	
	if(  mysql_query($sqldelexp, db_conexion()) && mysql_query($sqldelpac, db_conexion() ) && mysql_query($sqldelhis, db_conexion() ) && mysql_query($sqldelpat, db_conexion() ) ){
		cuadro_error("Datos Eliminados Correctamente...");
		 			echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
		
		}
	
	}


if ( isset( $_POST["acc"] ) and strtolower( $_POST["acc"])=="guardar"){
		//validaciones 
		if($_POST["cedula"]=="" or $_POST["nombre"]=="" or $_POST["apellido"]=="" or 
		$_POST["fec_nac"]=="" or $_POST["sexo"]=="" or $_POST["nomrep"]=="" or $_POST["telefono"]=="" or 
		$_POST["sala"]=="" or $_POST["direccion"]==""){
			cuadro_error("Debe llenar todos los campos");
		}else{
		
		
		//Subir imagen a nuestro fichero
		$foto=quitar($_POST["ant_foto"]);
		if($_FILES['userfile']['name']!=""){//comprueba que la imagen exista
		//INICIALIZACION DE VARIABLES PARA EL ARCHIVO
		//datos del arhivo
		$nombre_archivo = "fotopaciente/" . $_FILES['userfile']['name'];
		$tipo_archivo = $_FILES['userfile']['type'];
		$tamano_archivo = $_FILES['userfile']['size'];
		$nuevo_archivo= "fotopaciente/" . quitar($_POST["cedula"] .'.'. substr($tipo_archivo,6,4));
		//compruebo si las características del archivo son las que deseo
		  if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 5000000))) {
		    cuadro_error("La extensión o el tamaño de los archivos no es correcta, Se permiten archivos .gif o .jpg de 5 Mb máximo");
		    if($foto!="fotopasiente/NoPicture.gif"){
		  	$nuevo_archivo=$foto;
		    }else{
			$nuevo_archivo= "fotopaciente/NoPicture.gif";
  		         }	
		  }else{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $nombre_archivo)){
			   @unlink($foto);
			   rename($nombre_archivo,$nuevo_archivo);
   		  //  cuadro_mensaje("El archivo ha sido cargado correctamente");
  			}else{
   				    cuadro_error("Ocurrió algún error al subir el archivo. No pudo guardarse");
 			     }
		  } 
		}else{
 		 if($foto!="fotopaciente/NoPicture.gif"){
		  	$nuevo_archivo=$foto;
		  }else{
			$nuevo_archivo= "fotopaciente/NoPicture.gif";
  		       }

		//sino hay imagen asigna una por defecto
		//donde se llevan los datos a la BD
		if($_POST["apellido"]!=""){		
			if( isset($_POST["id_his"])  ) mysql_query("update historial set ced_pac='".$_POST["cedula"]."' where dni_historial='".$_POST["id_his"]."'", db_conexion() );
		}
			$sql="update paciente set ced='".$_POST["cedula"]."',nombre='".strtoupper($_POST["nombre"])."',apellido='".strtoupper($_POST["apellido"])."',fec_nac='".$_POST["fec_nac"]."',sexo='".$_POST["sexo"]."',nombre_representante='".strtoupper($_POST["nomrep"])."',pais='".$_POST["pais"]."',estado='".$_POST["estado"]."',ciudad='".$_POST["ciudad"]."',municipio='".strtoupper($_POST["municipio"])."',estado_civil='".$_POST["estciv"]."',emergencia='".$_POST["emergencia"]."',grusan='".$_POST["grusan"]."',vih='".$_POST["vih"]."',ocupacion='".$_POST["ocupacion"]."',alergico='".$_POST["alergico"]."',med_act='".$_POST["medact"]."',enf_act='".strtoupper($_POST["enfermedad"])."',peso='".strtoupper($_POST["peso"])."',talla='".strtoupper($_POST["talla"])."',foto='".$nuevo_archivo."' where id_paciente='".$_POST["id_pac"]."'";
			$sql2="update expediente set ced_paciente='".$_POST["cedula"]."',sala='".$_POST["sala"]."',direccion='".strtoupper($_POST["direccion"])."',telefono='".$_POST["telefono"]."' where dni_exp='".$_POST["id_exp"]."'";
			if(mysql_query($sql, db_conexion() )){
				if(mysql_query($sql2, db_conexion())){
					cuadro_error("paciente Actualizad@ Correctamente...");
					 echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
				}else{
				cuadro_error(mysql_error());//emite un mensaje de error de la BD sino se realizo la operacion
				 echo "<br><br><br><br><br>";
				require("../footer_inicio.php");
					exit;
				}
			}else{
				cuadro_error(mysql_error());
				}
		//////////////
		}
		}
}


?>
<br />
<div class="titulo">Actualizaci&oacute;n Datos de Paciente</div><br /><br />
<form action="act_est.php" method="post">
    <table align="center" class="tabla">
    
        <tr>
            
            <tr>
                <td colspan="2" align="center">Ingrese N&ordm; de Cedula del paciente</td>
            </tr>
            
            <tr>
                <td><input name="cedula1" type="text" value="" size="20"></td>
                <td><input type="submit" value="Buscar"></td>
            </tr>
        
        </tr>
    
    </table>
</form>
<?php

//busqueda en la base de datos
if( !empty( $_POST['cedula1'] ) ){
	
	$data = db_query( "select a.*,b.* from paciente a, expediente b where a.ced='".quitar($_POST["cedula1"])."' and a.ced=b.ced_paciente" );
	

	if( !empty( $data ) ){
	
		$cedula=$data[0]["ced"];
		$id_pac=$data[0]["id_paciente"];
		$id_exp=$data[0]["dni_exp"];
		$nombre=$data[0]["nombre"];
		$apellido=$data[0]["apellido"];
		$sexo=$data[0]["sexo"];
		$nomrep=$data[0]["nombre_representante"];
		$telefono=$data[0]["telefono"];
		$salas=$data[0]["sala"];
		$foto=$data[0]["foto"];
		$direccion=$data[0]["direccion"];
		$pais=$data[0]["pais"];
		$estado=$data[0]["estado"];
		$ciudad=$data[0]["ciudad"];
		$municipio=$data[0]["municipio"];
		$estciv=$data[0]["estado_civil"];
		$emergencia=$data[0]["emergencia"];
		$grusan=$data[0]["grusan"];
		$vih=$data[0]["vih"];
		$ocupacion=$data[0]["ocupacion"];
		$alergico=$data[0]["alergico"];
		$medact=$data[0]["med_act"];
		$enfermedad=$data[0]["enf_act"];
		$peso=$data[0]["peso"];
		$talla=$data[0]["talla"];
		$fec=str_replace( '-', '/', $data[0]["fec_nac"] );
		//$dia1=substr($data[0]["fec_nac"],8,2);
		//$mes1=substr($data[0]["fec_nac"],5,2);
		//$ano1=substr($data[0]["fec_nac"],0,4);
?>
<form name="registro" action="act_est.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="ant_foto" value="<?php echo $foto;?>">
    <input type="hidden" name="id_pac" value="<?php echo $id_pac;?>">
    <input type="hidden" name="id_exp" value="<?php echo $id_exp;?>">
    <?php 
	
	
	$r = db_query( "select dni_historial from historial where ced_pac='".$cedula."'" );
	
	
    if( !empty( $r ) ){echo '
                        <input type="hidden" name="id_his" value="'. $data[0]["dni_historial"] .''; }?>
                    
    <br>
    <table width="650" align="center" class="tabla">
    <tr>
        <td class="tdatos" colspan="2" align="center"><h3>DATOS PERSONALES DEL PACIENTE</h3></td>
    </tr>
    <tr>
        <td class="tdatos">C&eacute;dula</td>
        <td><input type="text" name="cedula" value="<?php echo $cedula; ?>" size="12" /></td>
    </tr>
    <tr>
        <td class="tdatos">Foto</td>
        <td><IMG SRC="<?php echo $foto; ?>" TITLE="<?php echo $nombre; ?>" WIDTH=80	HEIGHT=100></td>
    </tr>
    <tr>
        <td class="tdatos">Cambiar Foto</td>
        <td><input name="userfile" type="file"/></td>
    </tr>
    <tr>
        <td class="tdatos">Nombres</td>
        <td><input type="text" name="nombre" value="<?php echo $nombre; ?>" size="40" /></td>
    </tr>
    <tr>
        <td class="tdatos">Apellidos</td>
        <td><input type="text" name="apellido" value="<?php echo $apellido; ?>" size="40" /></td>
    </tr>
    <tr>
        <td  class="tdatos">Fecha de Nacimiento</td>
        <td><input type="text" name="fec_nac" value="<?php echo $fec; ?>" size="40" />a&ntilde;o/mes/d&iacute;a</td>
    </tr>
    <tr>
        <td class="tdatos">Sexo</td>
        <td>
            <select name="sexo">
                <option value="">Seleccione</option>
                <option value="M" <?php if ($sexo=="M") echo "selected" ?>>MASCULINO</option>
                <option value="F" <?php if ($sexo=="F") echo "selected" ?>>FEMENINO</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="tdatos">Nombre del Representante</td>
        <td><input type="text" name="nomrep" value="<?php echo $nomrep; ?>" size="40" /></td>
    </tr>
    <tr>
        <td class="tdatos">Telefonos</td>
        <td><input type="text" name="telefono" value="<?php echo $telefono; ?>" size="20" /></td>
    </tr>
    <tr>
        <td class="tdatos">Sala</td>
        <td>
                <select name="sala">
                <option value="">seleccione</option>
                
                <?php
                        $data = db_query( "select * from sala" );
						
						$chk =''; 
						
						if( !empty( $data ) ): foreach( $data as $sala ):
					?>
                    	
                        <?php  if( $sala["id_sala"]==$salas ) $chk = 'selected="selected"'; ?>
                        
                        <option <?php echo $chk ?> value="<?php echo $sala["id_sala"] ?>" ><?php echo $sala["denominacion"] ?></option>
                        
                    <?php	
						
						endforeach; endif;
						
					?>	
							
				
				
                </select>
        </td>
    </tr>
    <tr>
        <td class="tdatos">Direcci&oacute;n</td>
        <td><textarea rows="2" name="direccion" cols="40"><?php echo $direccion; ?></textarea></td>
    </tr>
    <tr>
        <td class="tdatos">Pais</td>
        <td>
            <select name="pais">
                <option value="">Seleccione</option>			
                <option value="ARG" <?php if ($pais=="ARG") echo "selected" ?>>ARGENTINA</option>
                <option value="BOL" <?php if ($pais=="BOL") echo "selected" ?>>BOLIVIA</option>
                <option value="BRA" <?php if ($pais=="BRA") echo "selected" ?>>BRASIL</option>
                <option value="CHI" <?php if ($pais=="CHI") echo "selected" ?>>CHILE</option>
                <option value="COL" <?php if ($pais=="COL") echo "selected" ?>>COLOMBIA</option>
                <option value="COS" <?php if ($pais=="COS") echo "selected" ?>>COSTA RICA</option>
                <option value="CUB" <?php if ($pais=="CUB") echo "selected" ?>>CUBA</option>
                <option value="REP" <?php if ($pais=="REP") echo "selected" ?>>REPUBLICA DOMINICANA</option>
                <option value="ECU" <?php if ($pais=="ECU") echo "selected" ?>>ECUADOR</option>
                <option value="ELS" <?php if ($pais=="ELS") echo "selected" ?>>EL SALVADOR</option>
                <option value="GUA" <?php if ($pais=="GUA") echo "selected" ?>>GUATEMALA</option>
                <option value="HAI" <?php if ($pais=="HAI") echo "selected" ?>>HAITI</option>
                <option value="HON" <?php if ($pais=="HON") echo "selected" ?>>HONDURAS</option>
                <option value="MEX" <?php if ($pais=="MEX") echo "selected" ?>>MEXICO</option>
                <option value="NIC" <?php if ($pais=="NIC") echo "selected" ?>>NICARAGUA</option>
                <option value="PAN" <?php if ($pais=="PAN") echo "selected" ?>>PANAMA</option>
                <option value="PAR" <?php if ($pais=="PAR") echo "selected" ?>>PARAGUAY</option>
                <option value="PER" <?php if ($pais=="PER") echo "selected" ?>>PERU</option>
                <option value="URU" <?php if ($pais=="URU") echo "selected" ?>>URUGUAY</option>
                <option value="VEN" <?php if ($pais=="VEN") echo "selected" ?>>VENEZUELA</option>
                                
                
                                                
            </select>
        </td>
    </tr>	
    <tr>
        <td class="tdatos">estado</td>
        <td><input type="text" name="estado" value="<?php echo $estado; ?>" size="13" /></td>
    </tr>
    <tr>
        <td class="tdatos">Ciudad</td>
        <td><input type="text" name="ciudad" value="<?php echo $ciudad; ?>" size="13" /></td>
    </tr>
    <tr>
        <td class="tdatos">municipio</td>
        <td><input type="text" name="municipio" value="<?php echo $municipio; ?>" size="15" /></td>
    </tr>
    <tr>
        <td class="tdatos">Estado Civil</td>
        <td>
            <select name="estciv">
                <option value="">Seleccione</option>
                <option value="C" <?php if ($estciv=="C") echo "selected" ?>>CASAD@</option>
                <option value="S" <?php if ($estciv=="S") echo "selected" ?>>SOLTER@</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="tdatos">Emergencia</td>
        <td><textarea rows="2" name="emergencia" cols="40"><?php echo $emergencia; ?></textarea></td>
    </tr>
    <tr>
        <td class="tdatos">Grupo Sanguineo</td>
        <td>
            <select name="grusan">
                <option value="">Seleccione</option>
                <option value="AME" <?php if ($grusan=="AME") echo "selected" ?>>A RH-</option>
                <option value="AMA" <?php if ($grusan=="AMA") echo "selected" ?>>A RH+</option>
                <option value="ABME" <?php if ($grusan=="ABME") echo "selected" ?>>AB RH-</option>
                <option value="ABMA" <?php if ($grusan=="ABMA") echo "selected" ?>>AB RH+</option>
                <option value="BME" <?php if ($grusan=="BME") echo "selected" ?>>B RH-</option>
                <option value="BMA" <?php if ($grusan=="BMA") echo "selected" ?>>B RH+</option>
                <option value="OME" <?php if ($grusan=="OME") echo "selected" ?>>O RH-</option>
                <option value="OMA" <?php if ($grusan=="OMA") echo "selected" ?>>O RH+</option>
                
            </select>
        </td>
    </tr>
    <tr>
        <td class="tdatos">VIH</td>
        <td>
            <select name="vih">
                <option value="">Seleccione</option>
                <option value="S" <?php if ($vih=="S") echo "selected" ?>>SI</option>
                <option value="N" <?php if ($vih=="N") echo "selected" ?>>NO</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="tdatos">Peso</td>
        <td><input type="text" name="peso" value="<?php echo $peso; ?>" size="5" /></td>
    </tr>
    <tr>
        <td class="tdatos">Talla</td>
        <td><input type="text" name="talla" value="<?php echo $talla; ?>" size="5" /></td>
    </tr>
    <tr>
        <td class="tdatos">Ocupacion</td>
        <td><input type="text" name="ocupacion" value="<?php echo $ocupacion; ?>" size="40" /></td>
    </tr>
    <tr>
        <td class="tdatos">Alergico</td>
        <td><textarea rows="4" name="alergico" cols="40"><?php echo $alergico; ?></textarea></td>
    </tr>
    <tr>
        <td class="tdatos">Medicamento Que Toma Actualmente</td>
        <td><textarea rows="4" name="medact" cols="40"><?php echo $medact; ?></textarea></td>
    </tr>
    <tr>
        <td class="tdatos">Enfermedad Que Tiene</td>
        <td><textarea rows="4" name="enfermedad" cols="40"><?php echo $enfermedad; ?></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="acc" value="Guardar">    
        &nbsp; 
        <input type="submit" name="del" value="Eliminar" onclick="confirmation();"></td>
    </tr>
    </table>
</form>
<?php
}else{
	echo "<br>";
	cuadro_error("Paciente No Encontrado <b><a href=reg_est.php  target=\"_self\">    Ir a Registrar</a></b>");	
}
}
?>

<?php
 echo "<br><br><br><br><br>";
require("../theme/footer_inicio.php");
?>
