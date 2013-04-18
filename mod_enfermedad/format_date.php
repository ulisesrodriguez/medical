<?php 
/*******************************************************************
**************     Medical Center Version 1.0.1    *****************
********************************************************************
***************  @Author ISC.Ulises Rodriguez T.   *****************
********************************************************************
***************   @Author Ing.Jorge Hernández.     *****************
********************************************************************
***************          @copyright 2010           ***************** 
********************************************************************
***************           @No modificar            *****************
********************************************************************/
?>
<?php
function meses($mes){
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", 									   "Diciembre");
	          switch($mes){
						case("01"):
						$mes = 0;
						break;
						case("02"):
						$mes = 1;
						break;
						case("03"):
						$mes = 2;
						break;
						case("04"):
						$mes = 3;
						break;
						case("05"):
						$mes = 4;
						break;
						case("06"):
						$mes = 5;
						break;
						case("07"):
						$mes = 6;
						break;
						case("08"):
						$mes = 7;
						break;
						case("09"):
						$mes = 8;
						break;
						case("10"):
						$mes = 9;
						break;
						case("11"):
						$mes = 10;
						break;
						case("12"):
						$mes = 11;
						break;
					}
					return $meses[$mes];
}
function fecha_completa($dia, $mes , $ano){
	
	$str_fecha = $dia."-".$mes."-".$ano;
	return $str_fecha;	
}
?>