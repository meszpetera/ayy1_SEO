<?php

include_once("common.php");
include_once("fpdf_with_barcode.php");
error_reporting(0);
$pdf = new PDF_With_Barcode('P', 'mm', 'A4');
$truck = get_truck_details($_REQUEST['truckid']);
$truck = $truck[0];

$pdf->AddPage();
$pdf->Image("../img/flyer/flyer_header_" . $lang . ".jpg", 3, 3, 204, 20);
$pdf->Cell(35, 25);
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(30, 0, $truck['truck_saxon-id']);
$pdf->Ln();
$pdf->Cell(30, 2);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 60);
$pdf->SetTextColor(255, 0, 0);
$pdf->Text(120, 275, $truck['truck_saxon-id']);

if ($truck['truck_state'] == 'E') {
    $pdf->SetFont('Arial', 'B', 40);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Text(130, 225, "Eladva");
}

if ($truck['truck_ispart'] == 0) {
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(100, 12, $truck['truck_make'] . ' ' . $truck['truck_model']);
    $pdf->Ln();
} else {
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(100, 12, iconv("UTF-8", "ISO-8859-2", $truck['truck_type']));
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 0, iconv("UTF-8", "ISO-8859-2", $truck['truck_make'] . ' ' . $truck['truck_model']));
    $pdf->Ln();
}

$pdf->SetTextColor(0, 0, 0);

$pdf->Code39(140, 33, $truck['truck_saxon-id']);
$pdf->Cell(30, 14);
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_type'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_type']), 0, 'L');

$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_function'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_function']), 0, 'L');

$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_status'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_status']), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_fuel'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_fuel']), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-load'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_max-load']) . ' kg', 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-height'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_max-height']), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_powered-wheel'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_powered-wheel']), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_steered-wheel'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_steered-wheel'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_engine'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_engine'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_drivetrain'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_drivetrain'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_hours-used'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_hours-used'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_year'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_year'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_serial'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_serial'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_weight'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_weight'])), 0, 'L');
$pdf->Cell(83, 5, "");

$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_forks'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_forks'])), 0, 'L');
$pdf->Cell(83, 5, "");

/* new */

$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_full-height'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_full-height'])), 0, 'L');
$pdf->Cell(83, 5, "");

$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_cabin-height'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_cabin-height'])), 0, 'L');
$pdf->Cell(83, 5, "");

$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_length'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_length'])), 0, 'L');
$pdf->Cell(83, 5, "");

$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_width'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_width'])), 0, 'L');
$pdf->Cell(83, 5, "");

$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_lifting-column-height'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_lifting-column-height'])), 0, 'L');
$pdf->Cell(83, 5, "");



/* /new */


$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_extras'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_extras'])), 0, 'L');
$pdf->Cell(83, 5, "");
/*
  $pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_comment'] . ':'));
  $pdf->MultiCell(60, 5,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_desc'])), 0, 'L');
  $pdf->Cell(83, 5, "");
 */
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_warranty'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_warranty'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_expected-arrival'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_expected-arrival'])), 0, 'L');
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_location'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", $truck['truck_location']), 0, 'L');
$pdf->Cell(83, 5, "");

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(44, 10, iconv("UTF-8", "ISO-8859-2", $language['truck-details_cost'] . ':'));
$pdf->MultiCell(60, 10, iconv("UTF-8", "ISO-8859-2", $truck['truck_cost'] . " EUR" . $language['truck-details_cost-VAT']), 0, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(83, 5, "");
$pdf->Cell(44, 5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_comment'] . ':'));
$pdf->MultiCell(60, 5, iconv("UTF-8", "ISO-8859-2", trim($truck['truck_desc'])), 0, 'L');



if (special_offer_active($truck)) {
    $pdf->Cell(83, 7, "");
    $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_special_offer_cost'] . ':'));
    $pdf->SetTextColor(255, 0, 0);
    $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['truck_special-offer-price'] . " EUR" . $language['truck-details_cost-VAT']), 0, 'L');
}


$c = get_image_count($_REQUEST['truckid']);


$col = 0;
$vdelta = 0;
$v = 0;

$defaultimg = get_truck_default_image($_REQUEST['truckid']);
if (is_file("../img/trucks/" . $defaultimg)) {
    list($width, $height, $type, $attr) = getimagesize("../img/trucks/" . $defaultimg);
    //echo 60.0/$width*$height;
    $vdelta = 80.0 / $width * $height;
    $pdf->Image("../img/trucks/" . $defaultimg, 10, 60, 80);
}

for ($i = 0; $i < $c; $i++) {
    $img = get_truck_image($truck['truck_id'], $i);

    if ($img != $defaultimg) {
        if (is_file('../img/trucks/' . $img)) {
            $imgsize = getimagesize("../img/trucks/" . $img);
            $ratio = 38 / $imgsize[0];

            if (($ratio * $imgsize[1] + 65 + $vdelta) < 280)
                $pdf->Image("../img/trucks/" . $img, 10 + ($col % 2) * 40, 65 + $vdelta, 38);


            if (($col % 2 == 0) || ($ratio * $imgsize[1] > $v))
                $v = $ratio * $imgsize[1];
            if ($col % 2 == 1)
                $vdelta += $v + 2;
        }

        $col++;
    }
}

if($truck['truck_default-image_label'] AND $truck['truck_default-image_label']!="1") {


    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(10, 53);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(255, 0, 0);
    $pdf->Cell(80,6,$truck['truck_default-image_label'],0,0,'C',true);
}

$pdf->Output();
?>