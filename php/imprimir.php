<?php
include('../php/conexion.php');
$id = $_GET['Id'];

//Incluimos la libreria fpdf
include("../fpdf/fpdf.php");
include("is_logged.php");

class PDF extends FPDF{
	function folioServicio(){
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
            $this->Ln(1);
            $this->MultiCell(60,4,utf8_decode('Descripción:__________________
            __________________________________________________________'),0,'L',true);
            $this->Ln(1);
            $this->MultiCell(60,4,utf8_decode('Total: $'.$Servicio['cantidad']),0,'L',true);
            if ($Servicio != 'Entregado') {
                 $this->Ln(1);
                $this->MultiCell(60,4,utf8_decode('Anticipo: $'.$Servicio['anticipo']),0,'L',true);
                $this->Ln(1);
                $Resta = $Servicio['cantidad']-$Servicio['anticipo'];
                $this->MultiCell(60,4,utf8_decode('Resta: $'.$Resta),0,'L',true);
            }         
            $this->Ln(2);
            $this->MultiCell(60,7,utf8_decode('Nos interesa su opinion:    
4331000222.
La especial "lavanderia".
laespecialsombrerete.com.
RECUERDE:
1.- Puede recoger su pedido a partidr del dia: '.$Servicio['fecha_entrega'].' 
2.- Presentar este ticket.
3.- En el tu tercer lavado "Recibe un descuento".
¡Todos los dias trabajamos para darte un mejor servicio!'),1,'C',true);
            $this->Image('../views/img/whats.png',20,92,8);
            $this->Image('../views/img/face.png',12,99,8);
            $this->Image('../views/img/web.png',11,107,7);

            mysqli_close($conn);
        }
    }

    $pdf = new PDF('P', 'mm', array(80,297));
    $pdf->SetTitle('Servicio');
    $pdf->folioServicio();
    $pdf->Output('Servicio','I');
?>