<?php
  include_once("common.php");
  include_once("fpdf_with_barcode.php");
    
  if(!loggedin() && !isauth())
  {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
  }
  else
  {
    $pdf=new PDF_With_Barcode('L', 'mm', array(101.6, 152.4));
    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    
      $stmt  = $mysql->prepare($sql['truck_details']);
      $stmt->bind_params($lang, $_REQUEST['truckid']);
      if($stmt->execute())
      {
        $pdf->AddPage();
        
        $id = $_SESSION['basket'][$i];
        $truckdetails = $stmt->fetch_all();      
        
        $pdf->SetFont('Arial', 'B', 20);
        
        $pdf->Text(5, 10, $truckdetails[0]['truck_saxon-id']);
        
        $pdf->SetFont('Arial', '', 16); 
        $pdf->Text(5, 16, $truckdetails[0]['truck_make'] . ' ' . $truckdetails[0]['truck_model']);
        
        $pdf->SetFont('Arial', '', 12); 
        $pdf->SetTextColor(160, 160, 160);
        $pdf->Text(5, 20, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_type'])); 
        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->Code39(96, 5, $truckdetails[0]['truck_saxon-id'], true, false, 0.35, 16);
        
        $pdf->Text(5, 29,   iconv("UTF-8", "ISO-8859-2", $language['truck-details_status'] . ':'));
        $pdf->Text(5, 34.5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_fuel'] . ':'));
        $pdf->Text(5, 40,   iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-height'] . ':'));
        $pdf->Text(5, 45.5, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-load'] . ':'));
        $pdf->Text(5, 51,   iconv("UTF-8", "ISO-8859-2", $language["truck-details_powered-wheel"] . ':'));
        $pdf->Text(5, 56.5, iconv("UTF-8", "ISO-8859-2", $language["truck-details_steered-wheel"] . ':'));
        $pdf->Text(5, 62,   iconv("UTF-8", "ISO-8859-2", $language["truck-details_engine"] . ':'));
        $pdf->Text(5, 67.5, iconv("UTF-8", "ISO-8859-2", $language["truck-details_drivetrain"] . ':'));
        $pdf->Text(5, 73,   iconv("UTF-8", "ISO-8859-2", $language["truck-details_hours-used"] . ':'));
        $pdf->Text(5, 78.5, iconv("UTF-8", "ISO-8859-2", $language["truck-details_year"] . ':'));
        $pdf->Text(5, 84,   iconv("UTF-8", "ISO-8859-2", $language["truck-details_serial"] . ':'));
        $pdf->Text(5, 89.5, iconv("UTF-8", "ISO-8859-2", $language["truck-details_weight"] . ':'));
        $pdf->Text(5, 95,   iconv("UTF-8", "ISO-8859-2", $language["truck-details_extras"] . ':'));

        $pdf->Text(50, 29,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_status']));
        $pdf->Text(50, 34.5, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_fuel']));
        $pdf->Text(50, 40,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_max-height']));
        $pdf->Text(50, 45.5, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_max-load']));
        $pdf->Text(50, 51,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_powered-wheel']));
        $pdf->Text(50, 56.5, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_steered-wheel']));
        $pdf->Text(50, 62,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_engine']));
        $pdf->Text(50, 67.5, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_drivetrain']));
        $pdf->Text(50, 73,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_hours-used']));
        $pdf->Text(50, 78.5, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_year']));
        $pdf->Text(50, 84,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_serial']));
        $pdf->Text(50, 89.5, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_weight']));
        $pdf->Text(50, 95,   iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_extras']));
        
  /*      $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_status'] . ':'));
        $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(70, 7, iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_status']), 0, 'L');
        $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_fuel'] . ':'));
        $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_fuel']), 0, 'L');      
        $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-height'] . ':'));
        $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_max-height']), 0, 'L');
        $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-load'] . ':'));
        $pdf->SetFont('Arial', '', 16); $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_max-load']) . ' kg', 0, 'L');
        $pdf->SetFont('Arial', '', 14); $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_description'] . ':'));
        $pdf->SetFont('Arial', '', 14); $pdf->MultiCell(60, 5.5,  iconv("UTF-8", "ISO-8859-2", $truckdetails[0]['truck_desc']), 0, 'L');
  */
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
    
    $pdf->Output();
  }
?>