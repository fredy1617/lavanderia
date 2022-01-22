<?php
include('../php/conexion.php');
$id = $_GET['Id'];

//Incluimos la libreria fpdf
include("../fpdf/fpdf.php");
include("is_logged.php");

class PDF extends FPDF{
	function folioCliente(){
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
            $this->MultiCell(60,4,utf8_decode('Descripción: '.$Servicio['descripcion']),0,'L',true);
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
            $this->MultiCell(60,7,utf8_decode('GRACIAS!!
RECUERDE:
1.- Puede recoger su pedido a partidr del dia: '.$Servicio['fecha_entrega'].' 
2.- Presentar este ticket.
3.- En el tu tercer lavado "Recibe un descuento".
4.- Visita nuestra pagina en facebook: La especial "lavanderia".
5.- Visita nuestra sitio web: laespecialsombrerete.com.
6.- Para alguna queja o sugerencia comuniquese al 4331000222.'),1,'C',true);

            mysqli_close($conn);
        }
    }

    $pdf = new PDF('P', 'mm', array(80,297));
    $pdf->SetTitle('Servicio');
    $pdf->folioCliente();
    $pdf->Output('Servicio','I');
?>