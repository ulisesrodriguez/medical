<?php
require("../theme/header_inicio.php");


if( !empty( $_POST ) ){
		
		
		//validaciones 
		if( empty( $_POST["ced"] ) or empty( $_POST["nombre"] ) or empty( $_POST["apellido"] ) 
			or empty( $_POST["fec_nac"] ) or empty( $_POST["sexo"] ) or empty( $_POST["nombre_representante"] ) 
			or empty( $_POST["telefono"] ) or  empty( $_POST["direccion"] )
		
		){
			
			
			cuadro_error("Debe llenar todos los campos");
		
		}else{
				
		
			//Subir imagen a nuestro fichero
			if($_FILES['userfile']['name']!=""){//comprueba que la imagen exista
				
				//INICIALIZACION DE VARIABLES PARA EL ARCHIVO
				//datos del arhivo
				
				$nombre_archivo = "fotopaciente/" . $_FILES['userfile']['name'];
				
				$tipo_archivo = $_FILES['userfile']['type'];
				
				$tamano_archivo = $_FILES['userfile']['size'];
				
				$nuevo_archivo= "fotopaciente/" . quitar($_POST["ced"] .'.'. substr($tipo_archivo,6,4));
			
			
				
				//compruebo si las características del archivo son las que deseo
				if ( !( ( strpos($tipo_archivo, "gif" ) || strpos( $tipo_archivo, "jpeg" ) ) && ( $tamano_archivo < 5000000 ) ) ) {
				
					cuadro_error("La extensión o el tamaño de los archivos no es correcta, Se permiten archivos .gif o .jpg de 5 Mb máximo");
				
				
				
				}else{
					if ( move_uploaded_file($_FILES['userfile']['tmp_name'], $nombre_archivo ) ){
					  
					   rename( $nombre_archivo, $nuevo_archivo );
					   
					   
					//  cuadro_mensaje("El archivo ha sido cargado correctamente");
					}else{
							cuadro_error("Ocurrió algún error al subir el archivo. No pudo guardarse");
					}
				} 
			
			}else{$nuevo_archivo= "fotopaciente/NoPicture.gif";}//sino hay imagen asigna una por defecto
				
				$_POST['foto'] = $nuevo_archivo;
																				
				$exp = array( 
					'ced_exp' => $_POST["ced"],
					'ced_paciente' => $_POST["ced"],
					'estado_exp' => 0,
					'sala' => $_POST["sala"], 
					'direccion' => $_POST["direccion"],
					'telefono' => $_POST["telefono"],
					'fec_gen_exp' => date( 'Y-m-d' ),
					'grusan' => $_POST["grusan"],
				);
							
				if( db_insertar( 'paciente', $_POST ) and db_insertar( 'expediente', $exp ) ){
					cuadro_error("Paciente Registrad@ Correctamente...");
					echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
					
				}else{
					cuadro_error(mysql_error());
				}
		
		}
		
}

?>
<br />
<div class="titulo">Registro del Paciente</div><br /><br />

<form name="registro" action="reg_est.php" method="post" enctype="multipart/form-data">
    <table width="700" align="center" class="tabla">
        <tr>
            <td class="tdatos" colspan="2" align="center"><h3>DATOS PERSONALES DEL PACIENTE</h3></td>
        </tr>
        <tr>
            <td class="tdatos">C&eacute;dula</td>
            <td class="dtabla"><input type="text" name="ced" value="<?php if( isset( $_POST['ced'] ) ) echo $_POST["ced"]; ?>" size="12" /></td>
        </tr>
        <tr>
            <td class="tdatos">Foto</td>
            <td class="dtabla"><input name="userfile" type="file"/></td>
        </tr>
        <tr>
            <td class="tdatos">Nombres</td>
            <td class="dtabla"><input type="text" name="nombre" value="<?php if( isset( $_POST['nombre'] ) ) echo $_POST["nombre"]; ?>" size="40" /></td>
        </tr>
        <tr>
            <td class="tdatos">Apellidos</td>
            <td class="dtabla"><input type="text" name="apellido" value="<?php  if( isset( $_POST['apellido'] ) ) echo $_POST["apellido"]; ?>" size="40" /></td>
        </tr>
        <tr>
            <td  class="tdatos">Fecha de Nacimiento</td>
            <td class="dtabla"><input type="text" name="fec_nac" value="<?php if( isset( $_POST['fec_nac'] ) ) echo $_POST["fec_nac"]; ?>" size="40" />a&ntilde;o/mes/d&iacute;a</td>
        </tr>
        <tr>
            <td class="tdatos">Sexo</td>
            <td class="dtabla">
                <select name="sexo">
                    <option value="">Seleccione</option>
                    <option value="M" <?php if ( isset( $_POST['fec_nac'] ) and $_POST["sexo"]=="M" ) echo "selected" ?>>MASCULINO</option>
                    <option value="F" <?php if ( isset( $_POST['fec_nac'] ) and $_POST["sexo"]=="F" ) echo "selected" ?>>FEMENINO</option>
                    
                
                
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdatos">Nombre del Representante</td>
            <td class="dtabla"><input type="text" name="nombre_representante" value="<?php if( isset( $_POST['nombre_representante'] ) ) echo $_POST["nombre_representante"]; ?>" size="40" /></td>
        </tr>
        <tr>
            <td class="tdatos">Telefonos</td>
            <td class="dtabla"><input type="text" name="telefono" value="<?php if( isset( $_POST['telefono'] ) ) echo $_POST["telefono"]; ?>" size="20" /></td>
        </tr>
        <tr>
            <td class="tdatos">Sala</td>
            <td class="dtabla">
                    <select name="sala">
                    <option value="">Seleccione</option>
                    <?php
                        $data = db_query( "select * from sala" );
						
						if( !empty( $data ) ): foreach( $data as $sala ):
					?>
                    	
                        <option value="<?php echo $sala["id_sala"] ?>"><?php echo $sala["denominacion"] ?></option>
                        
                    <?php	
						
						endforeach; endif;
						
					?>	
					
                    </select>	
            </td>
        </tr>
        <tr>
            <td class="tdatos">Direcci&oacute;n</td>
            <td class="dtabla"><textarea rows="2" name="direccion" cols="40"><?php if ( isset( $_POST['direccion'] ) ) echo $_POST["direccion"]; ?></textarea></td>
        </tr>
        <tr>
            <td class="tdatos">Pais</td>
            <td class="dtabla">
                <select name="pais">
                    <option value="">Seleccione</option>
                    <option value="ARG" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="ARG") echo "selected" ?>>ARGENTINA</option>
                    <option value="BOL" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="BOL") echo "selected" ?>>BOLIVIA</option>
                    <option value="BRA" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="BRA") echo "selected" ?>>BRASIL</option>
                    <option value="CHI" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="CHI") echo "selected" ?>>CHILE</option>
                    <option value="COL" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="COL") echo "selected" ?>>COLOMBIA</option>
                    <option value="COS" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="COS") echo "selected" ?>>COSTA RICA</option>
                    <option value="CUB" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="CUB") echo "selected" ?>>CUBA</option>
                    <option value="REP" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="REP") echo "selected" ?>>REPUBLICA DOMINICANA</option>
                    <option value="ECU" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="ECU") echo "selected" ?>>ECUADOR</option>
                    <option value="ELS" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="ELS") echo "selected" ?>>EL SALVADOR</option>
                    <option value="GUA" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="GUA") echo "selected" ?>>GUATEMALA</option>
                    <option value="HAI" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="HAI") echo "selected" ?>>HAITI</option>
                    <option value="HON" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="HON") echo "selected" ?>>HONDURAS</option>
                    <option value="MEX" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="MEX") echo "selected" ?>>MEXICO</option>
                    <option value="NIC" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="NIC") echo "selected" ?>>NICARAGUA</option>
                    <option value="PAN" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="PAN") echo "selected" ?>>PANAMA</option>
                    <option value="PAR" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="PAR") echo "selected" ?>>PARAGUAY</option>
                    <option value="PER" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="PER") echo "selected" ?>>PERU</option>
                    <option value="URU" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="URU") echo "selected" ?>>URUGUAY</option>
                    <option value="VEN" <?php if (isset( $_POST["pais"] ) and $_POST["pais"]=="VEN") echo "selected" ?>>VENEZUELA</option>
                                    
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdatos">Estado</td>
            <td class="dtabla"><input type="text" name="estado" value="<?php if (isset( $_POST["estado"] ) ) echo $_POST["estado"]; ?>" size="13" /></td>
        </tr>
        <tr>
            <td class="tdatos">Ciudad</td>
            <td class="dtabla"><input type="text" name="ciudad" value="<?php if (isset( $_POST["ciudad"] ) ) echo $_POST["ciudad"]; ?>" size="13" /></td>
        </tr>
        <tr>
            <td class="tdatos">Municipio</td>
            <td class="dtabla"><input type="text" name="municipio" value="<?php if (isset( $_POST["municipio"] ) ) echo $_POST["municipio"]; ?>" size="15" /></td>
        </tr>
        <tr>
            <td class="tdatos">Estado Civil</td>
            <td class="dtabla">
                <select name="estado_civil">
                    <option value="">Seleccione</option>
                    <option value="C" <?php if ( isset( $_POST["estado_civil"] ) and $_POST["estado_civil"]=="C") echo "selected" ?>>CASAD@</option>
                    <option value="S" <?php if ( isset( $_POST["estado_civil"] ) and $_POST["estado_civil"]=="S") echo "selected" ?>>SOLTER@</option>		
                
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdatos">Emergencia</td>
            <td class="dtabla"><textarea rows="2" name="emergencia" cols="40"><?php if ( isset( $_POST["emergencia"] ) ) echo $_POST["emergencia"]; ?></textarea></td>
        </tr>
        <tr>
            <td class="tdatos">Grupo Sanguineo</td>
            <td class="dtabla">
                <select name="grusan">
                    <option value="">Seleccione</option>
                    <option value="AME" <?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="AME") echo "selected" ?>>A RH-</option>
                    <option value="AMA" <?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="AMA") echo "selected" ?>>A RH+</option>
                    <option value="ABME"<?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="ABME") echo "selected" ?>>AB RH-</option>
                    <option value="ABMA"<?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="ABMA") echo "selected" ?>>AB RH+</option>
                    <option value="BME" <?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="BME") echo "selected" ?>>B RH-</option>
                    <option value="BMA" <?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="BMA") echo "selected" ?>>B RH+</option>
                    <option value="OME" <?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="OME") echo "selected" ?>>O RH-</option>
                    <option value="OMA" <?php if ( isset( $_POST["grusan"] ) and $_POST["grusan"]=="OMA") echo "selected" ?>>O RH+</option>		
                
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdatos">VIH</td>
            <td class="dtabla"> 
                <select name="vih">
                    <option value="">Seleccione</option>
                    <option value="S" <?php if ( isset( $_POST["vih"] ) and $_POST["vih"]=="S") echo "selected" ?>>SI</option>
                    <option value="N" <?php if ( isset( $_POST["vih"] ) and $_POST["vih"]=="N") echo "selected" ?>>NO</option>		
                
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdatos">Ocupacion</td>
            <td class="dtabla"><input type="text" name="ocupacion" value="<?php if ( isset( $_POST["ocupacion"] ) ) echo $_POST["ocupacion"]; ?>" size="20" /></td>
        </tr>
        <tr>
            <td class="tdatos">Alergico</td>
            <td class="dtabla"><textarea rows="4" name="alergico" cols="40"><?php if ( isset( $_POST["alergico"] ) ) echo $_POST["alergico"]; ?></textarea></td>
        </tr>
        <tr>
            <td class="tdatos">Medicamento Que Toma Actualmente</td>
            <td class="dtabla"><textarea rows="4" name="med_act" cols="40"><?php if ( isset( $_POST["med_act"] ) ) echo $_POST["med_act"]; ?></textarea></td>
        </tr>
        <tr>
            <td class="tdatos">Enfermedad Que Tiene</td>
            <td class="dtabla"><textarea rows="4" name="enf_act" cols="40"><?php if ( isset( $_POST["enf_act"] ) ) echo $_POST["enf_act"]; ?></textarea></td>
        </tr>
        
        <tr>
            <td class="tdatos">Peso</td>
            <td class="dtabla"><input type="text" name="peso" value="<?php if ( isset( $_POST["peso"] ) ) echo $_POST["peso"]; ?>" size="5" /></td>
        </tr>
        <tr>
            <td class="tdatos">Talla</td>
            <td class="dtabla"><input type="text" name="talla" value="<?php if ( isset( $_POST["talla"] ) ) echo $_POST["talla"]; ?>" size="5" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Registrar">
            <input name="Restablecer" type="reset" value="Limpiar" /></td>
        </tr>
    </table>
</form>
<?php
require("../theme/footer_inicio.php");
?>
