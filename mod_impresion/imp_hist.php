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
	$header_uno .= $pdf->text(10, 20, "Ciudad");
	$header_uno .= 	$pdf->text(10, 25, "Municipio");
	$header_uno .= $pdf->text(10, 30, "Tels");
	$header_uno .= $pdf->Image("../theme/images/header_logo.jpg", 150, 5);
	$pdf->Cell(190, 20,$header_uno);
	$pdf->Ln();
    $pdf->Cell(190, 10,"");
    $pdf->Ln();
/*************** Cuerpo del documento **************/
    $beg_bod = "Constancia del Historial";
    $pdf->Cell(190, 10,$beg_bod,0, 0, 'C');
    $pdf->Ln();
	$pdf->Image("../theme/images/header_logo.jpg", 30, 60, 150, 130);    
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
/**************** Campo Nombre del representante ****************/		
    $pdf->SetFont('Arial','B',10);
	$camp_nombrerep = "Nombre del Representante:";
    $camp_nombrerep_value = $_POST["nomrep"];
    $pdf->Cell(50, 8,$camp_nombrerep,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_nombrerep_value,1);
	$pdf->Ln();
/**************** Campo Nombre del profesional ****************/			
    $pdf->SetFont('Arial','B',10);
	$camp_nomprf = "Nombre del Profesional:";
    $camp_nomprf_value = $_POST["nomprf"];
    $pdf->Cell(50, 8,$camp_nomprf,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_nomprf_value,1);
	$pdf->Ln();
/**************** Campo Patologia ****************/		
    $pdf->SetFont('Arial','B',10);
	$camp_patologia = "Patologia:";
    $camp_patologia_value = $_POST["pat"];
    $pdf->Cell(50, 8,$camp_patologia,1);
    $pdf->SetFont("Times");
    $pdf->Cell(140, 8,$camp_patologia_value,1);
    $pdf->Ln();
/**************** Campo Habitos ****************/		
    $pdf->SetFont('Arial','B',10);
	$camp_habitos = "Habitos:";
    $camp_habitos_value = $_POST["hab"];
    $pdf->Cell(50, 8,$camp_habitos,1);
    $pdf->SetFont("Times");
    $pdf->MultiCell(140, 8,$camp_habitos_value,1);
    $pdf->Ln();
/**************** Campo Observacion ****************/		
    $pdf->SetFont('Arial','B',10);
	$camp_observa = "Observación:";
    $camp_observa_value = $_POST["observa"];
    $pdf->Cell(50, 8,$camp_observa,1);
    $pdf->SetFont("Times");
    $pdf->MultiCell(140, 8,$camp_observa_value,1);
    $pdf->Ln();
/**************** Campo Diagnostico ****************/    
    $pdf->SetFont('Arial','B',10);
	$camp_diagnostico = "Diagnostico:";
    $camp_diagnostico_value = $_POST["diagnostico"];
    $pdf->Cell(50, 8,$camp_diagnostico,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_diagnostico_value,1);
	$pdf->Ln();
/**************** Campo Tratamiento ****************/ 	
    $pdf->SetFont('Arial','B',10);
	$camp_tratamiento = "Tratamiento:";
    $camp_tratamiento_value = $_POST["tratamiento"];
    $pdf->Cell(50, 8,$camp_tratamiento,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_tratamiento_value,1);
	$pdf->Ln();
/**************** Campo Receta ****************/ 		
    $pdf->SetFont('Arial','B',10);
	$camp_receta = "Receta:";
    $camp_receta_value = $_POST["receta"];
    $pdf->Cell(50, 8,$camp_receta,1);
    $pdf->SetFont("Times");
	$pdf->MultiCell(140, 8,$camp_receta_value,1);
	$pdf->Ln();
	/**************** Campo fecha Gen. Expediente ****************/	
    $pdf->SetFont('Arial','B',10);		
	$camp_fec_gen_hist = "Fecha Gen. Historial:";
	$camp_fec_gen_hist_value = $_POST["fec_gen_hist"];
    $pdf->Cell(50, 8,$camp_fec_gen_hist,1);
    $pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_fec_gen_hist_value,1);
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
    $pdf->Cell(190, 20,"Constancia que se expide en Santa Ana de Coro, a los ___ dias del mes de ______  del  20___",0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190, 30,"Director del Ambulatorio",0,0, 'C');
    
    $pdf->Output();
	
	
	
	?>