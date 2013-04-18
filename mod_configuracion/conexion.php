<?php 
require 'sesion.php';
require 'functiones.php';

if ($_SESSION["login"]!=""){
    
	$result = mysql_query("SELECT * FROM usuarios WHERE login='".$_SESSION["login"]."' and password='".$_SESSION["password"]."'",$con);
    
	if (mysql_num_rows($result) == 1){
       $_SESSION["tipo"]=mysql_result($result,0,"tipo");
	   $_SESSION["nombre"]=mysql_result($result,0,"nombre");
	  } else
    {
        header("Location: login.php");
		exit;
    }
} else

{
 	header("Location: login.php");
	exit;
}
?> 

