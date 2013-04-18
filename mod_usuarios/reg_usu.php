<?php
require("../theme/header_inicio.php");

if(		isset( $_POST["nombre"] ) and !empty( $_POST["nombre"] ) 
		and isset( $_POST["login"] ) and !empty( $_POST["login"] ) 
		and isset( $_POST["pass1"] ) and !empty( $_POST["pass1"] ) 
		and isset( $_POST["pass2"] ) and !empty( $_POST["pass2"] ) 
		and isset( $_POST["tipo"] ) and !empty( $_POST["tipo"] ) 
		and isset( $_POST["ced_prof"] ) and !empty( $_POST["ced_prof"] ) 
		and isset( $_POST["nombre_prof"] ) and !empty( $_POST["nombre_prof"] ) 
		and isset( $_POST["tipo_prof"] ) and !empty( $_POST["tipo_prof"] ) 

  ){

	if ($_POST["pass1"] != $_POST["pass2"]){
		cuadro_error("Las contraseñas introducidas no coinciden");
	}else{
		
		$usu = array(
			'login' => $_POST["login"],
			'tipo' => $_POST["tipo"],
			'nombre' => $_POST["nombre"],
			'password' =>  md5( $_POST["pass1"] )
		);
		
		$prof = array(
			'ced_prof' => $_POST["ced_prof"],
			'nombre_apellido' => $_POST["nombre_prof"],
			'tipo_prof' => $_POST["tipo_prof"]
		
		);
		
		
		if( db_insertar( 'usuarios', $usu ) and	db_insertar( 'profesional', $prof )	){
		
		//if( db_insertar() 
			echo"<br /><br />";
			cuadro_error("Usuario Ingresado Correctamente. <b><a href=../mod_inicio/index.php target=\"_self\"> Volver a Inicio</a></b><br><br>");
			require("../theme/footer_inicio.php");
			exit;
		} else{
			cuadro_error(mysql_error());
		}
	
		
	}
	
}else
{
	cuadro_error("Debe llenar todos los campos.");
}





?>
<br />
<div class="titulo">Registro de Usuarios y Profesional</div><br /><br />

<form name="usuarios" action="reg_usu.php" method="post">
    <table class="tabla" align="center" width="500">
    <tr>
        <td colspan="2" class="tdatos" align="center"><h3>DATOS DEL USUARIO</h3></td>
    </tr>
    <tr>
        <td class="tdatos">Nombre:</td>
        <td><input type="text" name="nombre" value="<?php if( isset( $_POST["nombre"] ) ) echo $_POST["nombre"] ?>" size="45"></td>
    </tr>
    <tr>
        <td class="tdatos">Login</td>
        <td><input type="text" name="login" value="<?php if( isset( $_POST["login"] ) ) echo $_POST["login"] ?>" onchange="this.form.submit()" size="45"></td>
    </tr>
   
    <?php
    if ( isset( $_POST['login'] ) and !empty( $_POST["login"] ) ){
    
	
	$data = db_query( "SELECT login FROM usuarios WHERE login='".quitar($_POST["login"])."' LIMIT 1" );
		
    
	if( !empty( $data ) ){
            echo '
         <tr>
        <td class="cuadro_error" colspan="2" align="center">Este login pertenece a otro usuario, cambie login</td>
          </tr>
                 ';
    }else{
            echo '
         <tr>
        <td class="cuadro_mensaje" colspan="2" align="center">Login disponible</td>
          </tr>
                 ';
    }
    }
    ?>
    
    <tr>
        <td class="tdatos">Password:</td>
        <td><input type="password" name="pass1" value="" size="45"></td>
    </tr>
    <tr>
        <td class="tdatos">Repetir Password:</td>
        <td><input type="password" name="pass2" value="" size="45"></td>
    </tr>
    <tr>
        <td class="tdatos">Tipo:</td>
        <td>
            <select name="tipo">
                <option value="ADMINISTRADOR" <?php if ( isset( $_POST['tipo'] ) and $_POST['tipo']=="ADMINISTRADOR") echo "selected" ?>>ADMINISTRADOR</option>
                <option value="ASISTENTE" <?php if ( isset( $_POST['tipo'] ) and $_POST['tipo']=="ASISTENTE") echo "selected" ?>>ASISTENTE</option>
            </select>
        </td>
    </tr>
    <!-- Add data to Table Professional -->
    <tr>
        <td colspan="2" class="tdatos" align="center"><h3>DATOS DEL PROFECIONAL</h3></td>
    <tr>
        <td class="tdatos">Cedula del Profesional:</td>
        <td><input type="text" name="ced_prof" value="<?php if( isset( $_POST['ced_prof'] ) ) echo $_POST["ced_prof"]; ?>"  size="45" /></td>
    </tr>
    <tr>
        <td class="tdatos">Nombre:</td>
        <td><input type="text" name="nombre_prof" value="<?php if( isset( $_POST['nombre_prof'] ) ) echo $_POST["nombre_prof"]; ?>" size="45" /></td>
    </tr>
    <tr>
        <td class="tdatos">Tipo:</td>
        <td>
            <select name="tipo_prof">
                <option value="MEDICO" <?php if ( isset( $_POST['tipo_prof'] ) and $_POST['tipo_prof']=="MEDICO") echo "selected" ?>>MEDICO</option>
                <option value="ASISTENTE" <?php if ( isset( $_POST['tipo_prof'] ) and $_POST['tipo_prof']=="ASISTENTE") echo "selected" ?>>ASISTENTE</option>
                <option value="COORDINADOR" <?php if ( isset( $_POST['tipo_prof'] ) and $_POST['tipo_prof']=="COORDINADOR") echo "selected" ?>>COORDINADOR</option>
                <option value="PSICOLOGO" <?php if ( isset( $_POST['tipo_prof'] ) and $_POST['tipo_prof']=="PSICOLOGO") echo "selected" ?>>PSICOLOGO</option>
            </select>
            </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="acc" value="Registrar" size="20">
        <input name="Restablecer" type="reset" value="Limpiar" /></td>
    </tr>
    </table>
</form>

<br /><br />
<?php
require("../theme/footer_inicio.php");
?>
