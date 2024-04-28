<?php 
session_start();
require '../../backend/fpdf/fpdf.php';
date_default_timezone_set('America/Lima');

class PDF extends FPDF
{
    function Header()
    {
        // Inclusion should be outside of the method ideally, but for this case, it should work
        require_once('../../backend/bd/Conexion.php');
        $settings = $connect->prepare("SELECT nomem, foto, correo, telefono  FROM settings");
        $settings->execute();
        $setting = $settings->fetch(PDO::FETCH_ASSOC);

        $id = $_GET['id'];
        $doc = $connect->prepare("SELECT 
        CONCAT(
            COALESCE(d.nodoc, ' '), ' ', 
            COALESCE(d.apdoc, ' '),
            COALESCE(n.nomnur, ' '), ' ', 
            COALESCE(n.apenur, ' ')
        ) AS doctor
        FROM events e 
        INNER JOIN docnur dn ON dn.iddocnur = e.iddocnur
        INNER JOIN patients p ON e.idpa = p.idpa  -- Corrected s.idpa to e.idpa
        LEFT JOIN doctor d ON dn.idodc = d.idodc 
        LEFT JOIN nurse n ON dn.idnur = n.idnur
        LEFT JOIN event_labs el ON el.event_id = e.ideve
        LEFT JOIN laboratory l ON el.idlab = l.idlab
        WHERE e.id= '$id'");
        $doc->execute();
        $users = $doc->fetch(PDO::FETCH_ASSOC);

        // Corrected image path
        if (!empty($setting['foto'])) {
            $imagePath = '../../backend/img/subidas/' . htmlspecialchars($setting['foto']);
            if(file_exists($imagePath)) {
                $this->Image($imagePath, 25, 15, 35);
            }
        }

        $this->SetFont('times', 'B', 13);
        if (!empty($setting['foto'])) {
            $this->Text(75, 15, utf8_decode( htmlspecialchars($setting['nomem']) ));
        }
        $this->Text(75, 20, utf8_decode('Dr(a): ' . htmlspecialchars(mb_convert_case(mb_strtolower($users['doctor'], "UTF-8"), MB_CASE_TITLE, "UTF-8")) ));
        $this->Text(75, 25, utf8_decode('Tel: ' . htmlspecialchars($setting['telefono']) ));
        $this->Text(75, 30, utf8_decode(htmlspecialchars($setting['correo'])));
        $this->Ln(50);
    }


function Footer()
{
    require '../../backend/bd/Conexion.php';
    $settings = $connect->prepare("SELECT nomem, foto, correo, telefono  FROM settings");
    $settings->execute();
    $setting = $settings->fetch(PDO::FETCH_ASSOC);

     $this->SetFont('helvetica', 'B', 8);
        $this->SetY(-15);
        $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
        $this->Cell(95,5,date('d/m/Y | g:i:a') ,00,1,'R');
        $this->Line(10,287,200,287);
        $this->Cell(0, 5, utf8_decode(htmlspecialchars(mb_convert_case(mb_strtolower($setting['nomem'], "UTF-8"), MB_CASE_TITLE, "UTF-8")) . " © Todos los derechos reservados."), 0, 0, "C");
}

}
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();

$pdf->SetFont('Arial','B',10);
    
    $pdf->Cell(50, 7, utf8_decode('Motivo'),1,0,'C',0);
    $pdf->Cell(55, 7, utf8_decode('Paciente'),1,0,'C',0);

    $pdf->Cell(40, 7, utf8_decode('Fecha Inicio'),1,0,'C',0);
    $pdf->Cell(40, 7, utf8_decode('Fecha Fin'),1,1,'C',0);
   
    $pdf->SetFont('Arial','',10);

    //Aqui inicia el for con todos los productos

    


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
    WHERE e.id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();


while($row = $stmt->fetch()){


    $pdf->Cell(50, 7, utf8_decode($row['nomlab']),1,0,'L',0);
    $pdf->Cell(55, 7, utf8_decode($row['nompa']),1,0,'L',0);

    $pdf->Cell(40, 7, utf8_decode($row['start']),1,0,'C',0);
    $pdf->Cell(40, 7, utf8_decode( $row['end']),1,1,'C',0);
    
   
   

//// Apartir de aqui esta la tabla con los subtotales y totales

        $pdf->Ln(50);

        $pdf->setX(95);
        $pdf->Cell(40,6,'Subtotal',1,0);
        $pdf->Cell(60,6,'$ '.($row['monto']),'1',1,'R');
        $pdf->setX(95);
        
        $pdf->Cell(40,6,'Total',1,0);
        $pdf->Cell(60,6,'$ '.($row['monto']),'1',1,'R');


}

    $pdf->Output('boleta.pdf', 'I');
 ?>