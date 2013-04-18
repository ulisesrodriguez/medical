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
require_once("classpdf/fpdf.php");

/*********** Create PDF ***********************/
    $pdf = new fpdf('P','mm','A4');
	$pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
/***************  Header ***************************/
    $header_uno  = $pdf->Text(10, 15, "Direccion del ambulatorio aqui");
	$header_uno .= $pdf->text(10, 20, "Colonia");
	$header_uno .= 	$pdf->text(10, 25, "Ciudad");
	$header_uno .= $pdf->text(10, 30, "Tels");
	$header_uno .= $pdf->Image("../theme/images/header_logo.jpg", 150, 5);
	$pdf->Cell(190, 20,$header_uno);
	$pdf->Ln();
    $pdf->Cell(190, 10,"");
    $pdf->Ln();
/*************** Cuerpo del documento **************/
    $beg_bod = "Constancia de Expediente";
    $pdf->Cell(190, 10,$beg_bod,0, 0, 'C');
    $pdf->Ln();
	$pdf->Image("../theme/images/header_logo.jpg", 30, 80, 150, 130);    
/**************** Campo cedula ****************/	
    $pdf->SetFont('Arial','B',10);
	$camp_ced = "Cedula:";
	$camp_ced_value = $_POST["cedula"];
	$pdf->Cell(50, 8,$camp_ced,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_ced_value,1);
	$pdf->Ln();
/**************** Campo nombre ****************/
    $pdf->SetFont('Arial','B',10);		
	$camp_nombre = "Nombre:";
    $camp_nombre_value = $_POST["nombre"];
	$pdf->Cell(50, 8,$camp_nombre,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_nombre_value,1);
	$pdf->Ln();
/**************** Campo Apllido ****************/	
	$pdf->SetFont('Arial','B',10);	
	$camp_apellido = "Apellidos:";        
	$camp_apellido_value = $_POST["apellido"];
	$pdf->Cell(50, 8,$camp_apellido,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_apellido_value,1);
	$pdf->Ln();
/**************** Campo Edad ****************/	
	$pdf->SetFont('Arial','B',10);	
	$camp_edad = "Edad:";
	$camp_edad_value = $_POST["edad"];
    $pdf->Cell(50, 8,$camp_edad,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_edad_value,1);
	$pdf->Ln();
/**************** Campo fecha de nacimiento ****************/	
    $pdf->SetFont('Arial','B',10);		
	$camp_fechan = "Fecha de nacimiento:";
	$camp_fechan_value = $_POST["fech_nac"];
    $pdf->Cell(50, 8,$camp_fechan,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_fechan_value,1);
	$pdf->Ln();
/**************** Campo Sexo ****************/	
    $pdf->SetFont('Arial','B',10);	
    $camp_sexo = "Sexo:";
    $camp_sexo_value = $_POST["sexo"];
    $pdf->Cell(50, 8,$camp_sexo,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_sexo_value,1);
	$pdf->Ln();
/**************** Campo Sala ****************/		
	$pdf->SetFont('Arial','B',10);
	$camp_sala = "Sala:";
	$camp_sala_value = $_POST["sala"];
	$pdf->Cell(50, 8,$camp_sala,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_sala_value,1);
	$pdf->Ln();
/**************** Campo Telefono ****************/	    
	$pdf->SetFont('Arial','B',10);
	$camp_telefono = "Telefono:";
	$camp_telefono_value = $_POST["telefono"];
	$pdf->Cell(50, 8,$camp_telefono,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_telefono_value,1);
	$pdf->Ln();
/**************** Campo Nombre del representante ****************/		
    $pdf->SetFont('Arial','B',10);
	$camp_nombrerep = "Nombre del Representante:";
    $camp_nombrerep_value = $_POST["nomrep"];
    $pdf->Cell(50, 8,$camp_nombrerep,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_nombrerep_value,1);
	$pdf->Ln();
/**************** Campo Direccion ****************/			
    $pdf->SetFont('Arial','B',10);
	$camp_direccion = "Direccion:";
    $camp_direccion_value = $_POST["direccion"];
    $pdf->Cell(50, 8,$camp_direccion,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_direccion_value,1);
	$pdf->Ln();
/**************** Campo Emergencia ****************/		
    $pdf->SetFont('Arial','B',10);
	$camp_emergencia = "Emergencia:";
    $camp_emergencia_value = $_POST["emergencia"];
    $pdf->Cell(50, 8,$camp_emergencia,1);
    $pdf->SetFont("Times");
    $pdf->MultiCell(140, 8,$camp_emergencia_value,1);
    $pdf->Ln();
/**************** Campo Grupo sanginio ****************/    
    $pdf->SetFont('Arial','B',10);
	$camp_grusan = "Grupo Sanguineo:";
    $camp_grusan_value = $_POST["grusan"];
    $pdf->Cell(50, 8,$camp_grusan,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_grusan_value,1);
	$pdf->Ln();
/**************** Campo VIH ****************/ 	
    $pdf->SetFont('Arial','B',10);
	$camp_vih = "VIH:";
    $camp_vih_value = $_POST["vih"];
    $pdf->Cell(50, 8,$camp_vih,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_vih_value,1);
	$pdf->Ln();
/**************** Campo alergias ****************/ 	
    $pdf->SetFont('Arial','B',10);
	$camp_alergico = "Alergico:";
    $camp_alergico_value = $_POST["alergico"];
    $pdf->Cell(50, 8,$camp_alergico,1);
    $pdf->SetFont("Times");
	$pdf->MultiCell(140, 8,$camp_alergico_value,1);
	$pdf->Ln();
/**************** Campo Medicamentos ****************/ 		
    $pdf->SetFont('Arial','B',10);
	$camp_med = "Med. toma Actualmente:";
    $camp_med_value = $_POST["medact"];
    $pdf->Cell(50, 8,$camp_med,1);
    $pdf->SetFont("Times");
	$pdf->MultiCell(140, 8,$camp_med_value,1);
	$pdf->Ln();
/**************** Campo Enfermedad ****************/ 		
    $pdf->SetFont('Arial','B',10);
	$camp_enfermedad = "Enfermedad Que Tiene:";
    $camp_enfermedad_value = $_POST["enfermedad"];
    $pdf->Cell(50, 8,$camp_enfermedad,1);
    $pdf->SetFont("Times");
	$pdf->MultiCell(140, 8,$camp_enfermedad_value,1);
	$pdf->Ln();
/**************** Campo Estatus del expediente *********/ 
	$pdf->SetFont('Arial','B',10);
	$camp_est = "Estatus de Expediente:";
	$camp_est_value = $_POST["est"];
	$pdf->Cell(50, 8,$camp_est,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_est_value,1);
	$pdf->Ln();
/************* Footer ************************/	
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190, 20,"Constancia que se expide en Santa Ana de Coro, a los 25 dias del mes de Enero de    2010.",0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190, 30,"Director del Ambulatorio",0,0, 'C');
    
    $pdf->Output();
	
	
	
	?>