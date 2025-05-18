<?php
    include_once("common.php");
    include_once("fpdf_with_barcode.php");

    $pdf=new PDF_With_Barcode('P', 'mm', 'A4');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 0, 0);
    
    $truck = get_truck_details($_REQUEST['truckid']);
    $truck = $truck[0];

    $pdf->AddPage();
    $a = getAutoSpecOfferTrucks();
    foreach ($a as $k => $v)
    {
        $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $v['truck_saxon-id'])); $pdf->Ln();
    
    }

    $pdf->Output();
?>