<?php
  include_once("common.php");
  include_once("fpdf_with_barcode.php");
    
  $pdf=new PDF_With_Barcode('L', 'mm', 'A5');
  $mysql = get_connection();
  $mysql->execute($sql['setutf']);
  
  $c = count($_SESSION['basket']);  
  for ($i = 0; $i < $c; $i++)
  {
    $stmt  = $mysql->prepare($sql['truck_details']);
    $stmt->bind_params($lang, $_SESSION['basket'][$i]);
    if($stmt->execute())
    {
      $pdf->AddPage();
      
      $id = $_SESSION['basket'][$i];
      $truckdetails = $stmt->fetch_all();      
      
      $pdf->SetFont('Arial', 'B', 20);
      $pdf->Cell(30, 0, $truckdetails[0]['truck_saxon-id']); $pdf->Ln();
      $pdf->Cell(30, 2); $pdf->Ln();
      
      $pdf->SetFont('Arial', '', 16); 
      $pdf->Cell(100, 12, $truckdetails[0]['truck_make'] . ' ' . $truckdetails[0]['truck_model']); $pdf->Ln();
      
      $pdf->SetFont('Arial', '', 12); 
      $pdf->SetTextColor(160, 160, 160);
      $pdf->Cell(100, 0, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_type'])); $pdf->Ln();
      $pdf->SetTextColor(0, 0, 0);
      
      $pdf->Code39(150, 7, $truckdetails[0]['truck_saxon-id']);
      
      $img = get_truck_image($id, $truckdetails[0]['truck_default-image']);
      $img = ($img == "") ? "../img/trucks/truck_hires.jpg" : "../img/trucks/" . $img; 
      if (!is_file($img)) $img = "../img/trucks/truck_hires.jpg";
      
      $pdf->Image($img, 124, 36, 80);

      $pdf->Cell(30, 14); $pdf->Ln();
      $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_status'] . ':'));
      $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(70, 7, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_status']), 0, 'L');
      $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_fuel'] . ':'));
      $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_fuel']), 0, 'L');      
      $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-height'] . ':'));
      $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_max-height']), 0, 'L');
      $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-load'] . ':'));
      $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_max-load']) . ' kg', 0, 'L');
      $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_description'] . ':'));
      $pdf->SetFont('Arial', '', 14); $pdf->MultiCell(60, 5.5,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_description']), 0, 'L');
      
      /*$result .= '<div id="basketitem' . $id . '" class="BasketItem"><strong>' . $truckdetails[0]['truck_saxon-id'] . '</strong> ' . 
                 $truckdetails[0]['truck_make'] . ' ' . 
                 $truckdetails[0]['truck_model'] . ' ' . 
                 '<span style="color:#666">' . $truckdetails[0]['truck_type'] . '</span> ' .  
                 '<span style="color:#009">' . $truckdetails[0]['truck_cost'] . ' &euro;</span> ' . 
                 '<img id="basket_item_' . $id . '" src="img/aktualis/remove.gif" ' . 
                 'onmousemove="change_image(\'basket_item_' . $id . '\',\'img/aktualis/remove_h.gif\');" ' .
                 'onmouseout="change_image(\'basket_item_' . $id . '\',\'img/aktualis/remove.gif\');" ' .
                 'onclick="remove_truck_from_basket(' . $id . ')"' .
                 'alt="' . $_SESSION['basket'][$i] . '" /></div>';*/
    }
  }
  
  $pdf->Output();
?>