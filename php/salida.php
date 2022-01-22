<?php
include('../php/conexion.php');
$id = $_GET['Id'];

//Incluimos la libreria fpdf
include("../fpdf/fpdf.php");
include("is_logged.php");

class PDF extends FPDF{
	function folioServicio1(){
		global $id;
		global $conn;

		$Servicio = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servicios WHERE id = $id"));
		$id_cliente = $Servicio['id_cliente'];
		$cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE id = $id_cliente"));
		 // Colores de los bordes, fondo y texto
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0,0,0);
            $this->AddPage();
            $this->Image('../views/img/logo.jpg',10,8,60);
            $this->SetFont('Arial','B',13);
            $this->SetY(30);
            $this->Cell(90,4,'Fecha: '.$Servicio['fecha_entrada'],0,0,'C',true);
            $this->SetFont('Arial','',10);
            $this->Ln(8);
            $this->Cell(20,4,utf8_decode('No. Cliente: '.$Servicio['id_cliente']),0,0,'L',true);
            $this->Ln(5); 
            $this->Cell(20,4,utf8_decode('No. Servicio: '.$id),0,0,'L',true);
            $this->Ln(5);
            $this->MultiCell(60,4,utf8_decode('Cliente:'.$cliente['nombre']),0,'L',true);
            $this->SetFont('Arial','B',9);
            $this->Ln(2);
            $this->MultiCell(70,4,utf8_decode("SUBTOTAL"),0,'L',true);
            $this->MultiCell(70,4,utf8_decode("$ ".$Servicio['cantidad'].".00"),0,'R',true);
            $this->Ln(2);
            $this->MultiCell(70,4,utf8_decode("ANTICIPO"),0,'L',true);
            $this->MultiCell(70,4,utf8_decode("- $ ".$Servicio['anticipo'].".00"),0,'R',true);
            $this->Ln(2);
            $this->SetFont('Arial','B',11);
            $Resta = $Servicio['cantidad']-$Servicio['anticipo'];
            $this->MultiCell(70,4,utf8_decode('TOTAL:  $'.$Resta.'.00'),0,'R',true);
            $this->Ln(4);
            $this->SetFont('Arial','',10);      
            $this->MultiCell(70,4,utf8_decode('_________________________________'),0,'L',false);
            $this->SetX(6);
            $this->MultiCell(70,7,utf8_decode('Firma del Empleado'),0,'C',false);
            $this->MultiCell(60,7,utf8_decode('Nos interesa su opinion:    
4331000222.
La especial "lavanderia".
laespecialsombrerete.com.
RECUERDE:
1.- En el tu tercer lavado "Recibe un descuento".
¡Todos los dias trabajamos para darte un mejor servicio!'),1,'C',true);
            $this->Image('../views/img/whats.png',20,99,8);
            $this->Image('../views/img/face.png',12,106,8);
            $this->Image('../views/img/web.png',11,114,7);
    }

    function folioServicio2(){
        global $id;
        global $conn;

        $Servicio = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servicios WHERE id = $id"));
        $id_cliente = $Servicio['id_cliente'];
        $cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE id = $id_cliente"));
         // Colores de los bordes, fondo y texto
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0,0,0);
            $this->AddPage();
            $this->Image('../views/img/logo.jpg',10,8,60);
            $this->SetFont('Arial','B',13);
            $this->SetY(30);
            $this->Cell(90,4,'Fecha: '.$Servicio['fecha_entrada'],0,0,'C',true);
            $this->SetFont('Arial','',10);
            $this->Ln(8);
            $this->Cell(20,4,utf8_decode('No. Cliente: '.$Servicio['id_cliente']),0,0,'L',true);
            $this->Ln(5); 
            $this->Cell(20,4,utf8_decode('No. Servicio: '.$id),0,0,'L',true);
            $this->Ln(5);
            $this->MultiCell(60,4,utf8_decode('Cliente:'.$cliente['nombre']),0,'L',true);
            $this->SetFont('Arial','B',9);
            $this->Ln(2);
            $this->MultiCell(70,4,utf8_decode("SUBTOTAL"),0,'L',true);
            $this->MultiCell(70,4,utf8_decode("$ ".$Servicio['cantidad'].".00"),0,'R',true);
            $this->Ln(2);
            $this->MultiCell(70,4,utf8_decode("ANTICIPO"),0,'L',true);
            $this->MultiCell(70,4,utf8_decode("- $ ".$Servicio['anticipo'].".00"),0,'R',true);
            $this->Ln(2);
            $this->SetFont('Arial','B',11);
            $Resta = $Servicio['cantidad']-$Servicio['anticipo'];
            $this->MultiCell(70,4,utf8_decode('TOTAL:  $'.$Resta.'.00'),0,'R',true);
            $this->Ln(4);
            $this->Ln(4);
            $this->SetFont('Arial','',10);      
            $this->MultiCell(70,4,utf8_decode('_________________________________'),0,'L',false);
            $this->SetX(6);
            $this->MultiCell(70,7,utf8_decode('Firma de Conformidad'),0,'C',false);
            $this->Ln(1);  
            $this->MultiCell(60,7,utf8_decode('¡ Otro cliente satisfecho !'),1,'C',true);
    }
}

    $pdf = new PDF('P', 'mm', array(80,297));
    $pdf->SetTitle('Servicio');
    $pdf->folioServicio1();
    $pdf->folioServicio2();
    $pdf->Output('Servicio','I');
    date_default_timezone_set('America/Mexico_City');
    $Hoy = date('Y-m-d'); 
    mysqli_query($conn,"UPDATE servicios SET estatus ='Entregado', fecha_salida = '$Hoy' WHERE  id = '$id'");

    mysqli_close($conn);
?>