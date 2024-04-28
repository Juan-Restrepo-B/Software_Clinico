<?php
require('../../backend/fpdf/fpdf.php');
date_default_timezone_set('America/El_Salvador');

require_once('../../backend/bd/Conexion.php');
        $settings = $connect->prepare("SELECT nomem, foto, correo, telefono  FROM settings");
        $settings->execute();
        $setting = $settings->fetch(PDO::FETCH_ASSOC);

//podemos definir el ancho en una variable para que no les cueste cambiarlo despues
$ancho = 5;

//definimos la orientacion de la pagina y el array indica el tamaño de la hoja
$pdf=new FPDF('P','mm',array(80,150));
$pdf->AddPage(); 
$pdf->SetFont('Arial','B',8);   

$pdf->setY(5);
$pdf->setX(15);

$pdf->Cell(50,$ancho, utf8_decode( htmlspecialchars($setting['nomem']) ),'B',0,'C');
$pdf->Ln(6);
$pdf->SetFont('Arial','',7);   

$pdf->setX(5);
//              Encabezado

$pdf->Cell(20, 7, utf8_decode('Paciente'),0,0,'C',0);
$pdf->Cell(25, 7, utf8_decode('Médico'),0,0,'C',0);
$pdf->Cell(20, 7, utf8_decode('Total'),0,1,'C',0);

//              DATOS


$pdf->setX(5);


 require '../../backend/bd/Conexion.php';
    $id = $_GET['id'];
    $stmt = $connect->prepare("SELECT e.id, e.title, p.idpa, 
    p.numhs, p.nompa, p.apepa, d.idodc, d.ceddoc, 
    d.nodoc, d.apdoc, l.idlab, l.nomlab, e.start, 
    e.end, e.color, e.state, e.chec, e.monto 
    FROM events e
    INNER JOIN docnur dn ON dn.iddocnur = e.iddocnur
    INNER JOIN patients p ON e.idpa = p.idpa
    LEFT JOIN doctor d ON dn.idodc = d.idodc 
    LEFT JOIN nurse n ON dn.idnur = n.idnur
    LEFT JOIN event_labs el ON el.event_id = e.ideve
    LEFT JOIN laboratory l ON el.idlab = l.idlab
    WHERE e.id= '$id'");
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

while($row = $stmt->fetch()){


$pdf->Cell(20, 5, utf8_decode(mb_convert_case(mb_strtolower($row['nompa'], "UTF-8"), MB_CASE_TITLE, "UTF-8")),0,0,'C',0);
$pdf->Cell(25, 5, utf8_decode(mb_convert_case(mb_strtolower($row['nodoc'], "UTF-8"), MB_CASE_TITLE, "UTF-8") ."\n".  mb_convert_case(mb_strtolower($row['apdoc'], "UTF-8"), MB_CASE_TITLE, "UTF-8")),0,0,'C',0);
$pdf->Cell(20, 5,'$ '.($row['monto']),0,1,'C',0);


$pdf->Ln(5);
//              TOTAL
$pdf->setX(5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(45,5,'TOTAL',0,0,'L',0);

$pdf->SetFont('Arial','',8);
$pdf->Cell(10,5,'$ '.($row['monto']));


}

$pdf->Ln(10);
$pdf->SetFont('Arial','B',8);
$pdf->setX(15);
$pdf->Cell(5,$ancho+6,utf8_decode('¡GRACIAS POR TU COMPRA!'));

$pdf->Output('ticket.pdf', 'I');
?>