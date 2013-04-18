<?php
require "mod_configuracion/sesion.php";
require "mod_configuracion/funciones.php";

if ( !empty( $_POST ) ){
	
	$data = db_query(
		"	SELECT * 
			FROM usuarios 
			WHERE login='".htmlentities($_POST["usuario"])."' 
			AND password='". md5($_POST["password"])."' LIMIT 1;" );
		
		
	if( !empty( $data ) ){
		
		
		$_SESSION["login"] = $data[0]["login"];
		$_SESSION["password"] = $data[0]["password"];
		$_SESSION["nombre" ] =  $data[0]["nombre"];
		$_SESSION["tipo" ] =  $data[0]["tipo"];
		header("Location: mod_inicio/index.php");
		
		
	}else{
	?>
        <script type="text/javascript">
		alert("\tUsuario o Password incorrecto \n \t Favor de verificar los datos");
		window.location = "mod_inicio/index.php";
		</script>
		<?php 
    }
}
?>		

<script type="text/javascript">
		window.location = "index.php";
</script>