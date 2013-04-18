<?php

function db_conexion(){
	
	$con = mysql_connect( 'localhost', 'root',  '' );
	
	mysql_select_db( 'paciente', $con );
	
	mysql_query( "SET NAMES 'utf8'", $con ); 
	
	if( !$con ){ echo '<h1>Error al conectarse a la base de datos</h1>'; exit; }

	return $con;
	
}


function db_insertar( $table = null, $data = array() ){
	
	
	if( empty( $table ) or empty( $data ) ) return false;
		
	// Dynamic query
	$sql =	"INSERT INTO `". $table ."`( "; 
		
		foreach( $data as $key => $value )			
			$sql .= "`". strip_tags( $key ) ."`, ";	
	
					
	$sql .= ') VALUES ( ';	
	
		foreach( $data as $value )
				$sql .= " '". strip_tags( $value ) ."', ";	
		
	$sql .= ');';	
	
	$sql = str_replace( ', )', ' )', $sql );	
		
	$res = mysql_query( $sql, db_conexion() );
				
		
	if( mysql_affected_rows() > 0 )
		return true;
	else
		return false;
				
  }


function db_update( $table = null, $data = array(), $conditions = array() ){
	  

	if( empty( $table ) or empty( $data ) or empty( $conditions ) ) return false;
				 

	$sql =	"UPDATE `". $table ."` 
			   SET";
	
	foreach( $data as $key => $value )							
		$sql .= ", `". strip_tags( $key )  ."`='". strip_tags( $value ) ."'" ;
	
	
	$condition = ' WHERE ';	
	
	foreach( $conditions as $key => $value ){
				
		if( $condition == ' WHERE ' ){
			$sql .= " WHERE `". strip_tags( $key )  ."`='". strip_tags( $value )  ."' ";
			$condition = ' AND ';
		
		}else if( $condition == ' AND ' )
			$sql .= " AND `". strip_tags( $key )  ."`='". strip_tags( $value )  ."' ";		
				
	}		
	
	
	
	$count = strlen( 'UPDATE `'. $table  .'` SET,        ');

	$sql = substr_replace( $sql, 'UPDATE `'. $table .'` SET',0, $count );
	
	$sql .= '; ';
				
	$res = mysql_query( $sql, db_conexion() );
			
	if( mysql_affected_rows() > 0 )
		return true;
	else
		return false;
	 
	 
  }
  
   function db_delete( $table = null, $data = null ){
	 

	if( empty( $table ) or empty( $data ) ) return false;
	
	
	$sql = ' DELETE FROM `'.$table.'` ';
	 
	$condition = ' WHERE ';	
	
	foreach( $data as $key => $value ){
					
		if( $condition == ' WHERE ' ){
			$sql .= " WHERE `". strip_tags( $key )  ."`='". strip_tags( $value ) ."' ";
			$condition = ' AND ';
			
		}else if( $condition == ' AND ' )
			$sql .= " AND `". strip_tags( $key )  ."`='". strip_tags( $value ) ."' ";		
					
	}		
	 
	 $sql .= ';';
	 
	 $res = mysql_query( $sql, db_conexion() );
	 
	 if( mysql_affected_rows() > 0 )
		return true;
      else
		return false; 	  
  
}



function db_query( $query = null ){
	 
	if( empty( $query ) )  return false;
	
	$res = mysql_query( ( $query ), db_conexion() );
	
	if( mysql_num_rows( $res ) == 0 ) return false;
	
	unset( $data ); $data = array();	
	 
	while( $reg = mysql_fetch_assoc( $res ) )	 				
			$data[] = $reg;	
			
	return $data;
	 
}




function cuadro_error( $mensaje ){

		if ( $mensaje != "" ){
		
			echo '
				<table width="300" align="center" class="cuadro_error">
				<tr>
					<td><div class="mensaje_error">'.$mensaje.'</div></td>
				</tr>
				</table><br />
			';
		
		}

}

function quitar($mensaje){
	
	$mensaje = str_replace("<","&lt;",$mensaje);
	$mensaje = str_replace(">","&gt;",$mensaje);
	$mensaje = str_replace("\'","&#39;",$mensaje);
	$mensaje = str_replace('\"',"&quot;",$mensaje);
	$mensaje = str_replace("\\\\","&#92;",$mensaje);
	$mensaje = str_replace(" ","",$mensaje);
	$mensaje = str_replace("+","",$mensaje);

	return $mensaje;

	
}

function fecha($fecha){
	
	$dia=substr($fecha,8,2);
	$mes=substr($fecha,5,2);
	$ano=substr($fecha,0,4);
	return $dia.'/'.$mes.'/'.$ano;

}


function numero($str){
	
  $legalChars = "%[^0-9\-\. ]%";

  $str=preg_replace($legalChars,"",$str);
  
  return $str;
}

function admin(){

	if ($_SESSION["tipo"]!="AD"){
		cuadro_error("ACCESO RESTRINGIDO A ESTA SECCION");
		exit;
	}
}

?>
