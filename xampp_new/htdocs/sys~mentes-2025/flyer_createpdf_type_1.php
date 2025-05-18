<?php
  function print_flyer_page_type_1($page, $pdf, $flyer_lang, $useLargeImages = false)
  {
    $pdf->AddPage();
      
    $pdf->SetFillColor(95, 159, 158);
    $pdf->Rect(0, 0, 210, 297, 'F');
      
    $pdf->Image("../img/flyer/flyer_header_" . $flyer_lang . ".jpg", 3, 3, 204, 20);
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->SetLineWidth(0.25);
    
    for ($i = 0; $i < 5; $i++)
    {
      for ($j = 0; $j < 4; $j++)
      {
        $id = $i*4 + $j;
        
        $pdf->SetFillColor(161, 197, 195);
        $pdf->Rect(3.25 + 51.5*$j, 26.25 + 54*$i, 49, 51.5, 'FD');
        
        if (!isset($page['trucks'][$id]))
        {
          $pdf->Image("../img/trucks/elegent light.jpg", 3 + 51.5*$j, 30 + 54*$i, 49.5, 37.125);
        }
        else
        {
          $truck = get_truck_details($page['trucks'][$id]['id'], $flyer_lang);
        
          $pdf->SetFont('Arial', 'B', 10);
          $pdf->Text(3.5 + 51.5*$j, 29.4 + 54*$i, $truck[0]['truck_saxon-id']);
          $pdf->SetFont('Arial', '', 10);
          
          if (special_offer_active($truck[0]))
          {
            $pdf->SetTextColor(255, 0, 0);
            $w = $pdf->GetStringWidth($truck[0]['truck_special-offer-price'] . " €");
            $pdf->Text(51.8 + 51.5*$j - $w, 29.4 + 54*$i, $truck[0]['truck_special-offer-price'] . " €");   
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetDrawColor(0, 0, 0);
            $w2 = $pdf->GetStringWidth($truck[0]['truck_cost'] . " €");
            $pdf->Text(51.8 + 51.5*$j - $w - $w2, 29.4 + 54*$i, $truck[0]['truck_cost'] . " €");      
            $pdf->Line(51.8 + 51.5*$j - $w - $w2, 28.5 + 54*$i, 51.8 + 51.5*$j - $w, 28.5 + 54*$i);
          }
          else
          {
            $w = $pdf->GetStringWidth($truck[0]['truck_cost'] . " €");
            $pdf->Text(51.8 + 51.5*$j - $w, 29.4 + 54*$i, $truck[0]['truck_cost'] . " €");
          }   
          
          $img = get_truck_image($page['trucks'][$id]['id'], $truck[0]['truck_default-image']);
          if (is_file("../img/trucks/" . str_replace(".jpg", "_max.jpg", $img)) && $useLargeImages)
            $pdf->Image("../img/trucks/" . str_replace(".jpg", "_max.jpg", $img), 3 + 51.5*$j, 30 + 54*$i, 49.5, 36.125);
          else if (is_file("../img/trucks/" . $img))
			{
			  //zlibism: let's compress this shit
			  $compressImage = imagecreatefromjpeg("../img/trucks/" . $img);
			  imagejpeg($compressImage, "../img/trucks/" . $img . ".compressed.jpg", 40);
			  
					$pdf->Image("../img/trucks/" . $img . ".compressed.jpg", 3 + 51.5*$j, 30 + 54*$i, 49.5, 36.125);
			}
          else
            $pdf->Image("../img/trucks/truck_hires.jpg", 3 + 51.5*$j, 30 + 54*$i, 49.5, 36.125);
            
          $pdf->SetFont('Arial', '', 8);
          $pdf->Text(3.5 + 51.5*$j, 69 + 54*$i, iconv("UTF-8", "ISO-8859-2", $truck[0]['truck_make'] . ' ' . $truck[0]['truck_model']));
          $pdf->SetFont('Arial', '', 6);
          $pdf->Text(3.5 + 51.5*$j, 72 + 54*$i, lowercase(iconv("UTF-8", "ISO-8859-2", $truck[0]['truck_type'])));
          $pdf->Text(3.5 + 51.5*$j, 74.5 + 54*$i, lowercase(utf8_decode($truck[0]['truck_status'])));
          $pdf->Text(3.5 + 51.5*$j, 77 + 54*$i, lowercase(iconv("UTF-8", "ISO-8859-2", $truck[0]['truck_fuel'])) . ', max. ' . $truck[0]['truck_max-load'] . ' kg, ' . trim(lowercase(utf8_decode($truck[0]['truck_max-height']))));
        }
        
        $pdf->SetDrawColor(255, 204, 1);
        $pdf->Rect(3 + 51.5*$j, 26 + 54*$i, 49.5, 52);
        $pdf->SetDrawColor(95, 159, 158);
        $pdf->Rect(3.25 + 51.5*$j, 26.25 + 54*$i, 49, 51.5);
      }
    }
  }
?>
