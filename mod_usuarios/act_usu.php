<?php
require("../theme/header_inicio.php");

if(		isset( $_POST["nombre_"] ) and !empty( $_POST["nombre_"] ) 
		or isset( $_POST["login_"] ) and !empty( $_POST["login_"] ) 
		or isset( $_POST["pass_"] ) and !empty( $_POST["pass_"] ) 
		or isset( $_POST["pass_2"] ) and !empty( $_POST["pass_2"] ) 
		or isset( $_POST["tipo_"] ) and !empty( $_POST["tipo_"] ) 

  ){

	if ( isset( $_POST["pass1"] ) and isset( $_POST["pass2"] ) and ( $_POST["pass1"] != $_POST["pass2"] )){
		cuadro_error("Las contraseñas introducidas no coinciden");
	}else{
		
		$usu = array(
			'login' => $_POST["login_"],
			'tipo' => $_POST["tipo_"],
			'nombre' => $_POST["nombre_"],
		);
		
		if( isset( $_POST['pass1'] ) )
			$usu['password'] = md5( $_POST["pass_"] );
		
				
		
		if( db_update( 'usuarios', $usu, array( 'id_usu' => $_POST['iduser'] ) ) ){
		
		//if( db_insertar() 
			echo"<br /><br />";
			cuadro_error("Usuario se modifico Correctamente. <b><a href=../mod_inicio/index.php target=\"_self\"> Volver a Inicio</a></b><br><br>");
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
<div class="titulo">Modificaci&oacute;n de Usuarios</div><br />
<div align="center"><br />
<br />
 
</div>
<div id="centercontent">
  <div align="center">
    <table>
      <td>
        <form action="act_usu.php" method="post">
          <input type="hidden" name="modificacion" value="login">
          <table class="tabla">
            <tr>
              <td colspan="2" align="center">Introduzca Login del Medico</td>
		    </tr>
            <tr>
              <td><input type="text" name="login" value="<?php if( isset( $_POST['login'] ) )   echo $_POST["login"]; ?>" size="15"></td>
			    <td><input type="submit" value="Buscar"></td>
		    </tr>
            </table>
	    </form>    </td>
    <td>
      <form action="act_usu.php" method="post">
        <input type="hidden" name="modificacion" value="nombre">
        <table class="tabla">
          <tr>
            <td colspan="2" align="center">Ingrese Nombre del Medico</td>
		    </tr>
          <tr>
            <td><input type="text" name="nombre" value="<?php if( isset( $_POST['nombre'] ) ) echo $_POST["nombre"]; ?>" size="15"></td>
			    <td><input type="submit" value="Buscar"></td>
		    </tr>
          </table>
	    </form>    </td>
    </table>
  </div>
</div>
<div align="center">
<?php

$data = array();

if ( isset( $_POST['login'] ) and !empty( $_POST["login"] ) or isset( $_POST['nombre'] ) and  !empty( $_POST["nombre"] ) ){
	
	switch ($_POST["modificacion"]){
		case'login':
			
			$data = db_query( "SELECT * FROM usuarios WHERE login='".$_POST["login"]."' LIMIT 1" );

		break;
		case'nombre':
			
			$data = db_query( "SELECT * FROM usuarios WHERE nombre='".$_POST["nombre"]."' LIMIT 1" );
		break;
}

if ( !empty( $data ) ){

?>
</div>
<form name="usuarios" action="act_usu.php" method="post">
<input type="hidden" name="iduser" value="<?php echo $data[0]["id_usu"];?>">
<table class="tabla" align="center" width="500">
<tr>
	<td colspan="4" class="tdatos" align="center"><h3>DATOS DEL USUARIO MEDICO</h3></td>
</tr>
<tr>
	<td class="tdatos">Nombre</td>
	<td><input type="text" name="nombre_" value="<?php echo $data[0]["nombre"]; ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Login</td>
	<td><input type="text" name="login_" value="<?php echo $data[0]["login"]; ?>" readonly size="45"></td>
</tr>
<tr>
	<td class="tdatos">Password</td>
	<td><input type="password" name="pass_" value="" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Repetir Password</td>
	<td><input type="password" name="pass_2" value="" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Tipo</td>
	<td>
		<select name="tipo_">
			<option value="ADMINISTRADOR" <?php if ( isset( $data[0]['tipo'] ) and $data[0]['tipo']=="ADMINISTRADOR") echo "selected" ?>>ADMINISTRADOR</option>
            <option value="ASISTENTE" <?php if ( isset( $data[0]['tipo'] ) and $data[0]['tipo']=="ASISTENTE") echo "selected" ?>>ASISTENTE</option>
		</select>
	</td>
</tr>
<tr>
	<td colspan="3" align="center"><input type="submit" name="acc" value="Modificar" size="20"></td>
</tr>
</table>
</form>

<?php
	}else{
		cuadro_error ("No se encontraron registros");
	}
}
?>

<?php
require("../theme/footer_inicio.php");
?>
