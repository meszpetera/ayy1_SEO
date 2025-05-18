<?php
  include_once("common.php");
  include_once("fpdf_with_barcode.php");
  include_once("flyer_createpdf_type_0.php");
  include_once("flyer_createpdf_type_1.php");
    
  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {  
    if (isset($_REQUEST['flyer_lang']))
      $flyer_lang = $_REQUEST['flyer_lang'];
    else 
      $flyer_lang = "eng";
  
    if ($savetofile == 1)
    {
		$c = $_SESSION['flyers']['pagecount'];
        if (!is_dir('../saved_flyers/' . $_SESSION['flyer_title']))
            mkdir('../saved_flyers/' . $_SESSION['flyer_title']);
		$htaccess = '../saved_flyers/' . $_SESSION['flyer_title'] . ".htaccess";
		if (!is_file($htaccess))
		{
			$fh = fopen($htaccess, 'w');
			$data = "Options +Indexes\n";
			fwrite($fh, $data);
			fclose($fh);
		}
        //hi-res
		for ($i = 0; $i < $c; $i++)
		{
			$pdf = new PDF_With_Barcode('P', 'mm', 'A4');
			
			if ($_SESSION['flyers'][$i]['pagetype'] == 0)
				print_flyer_page_type_0($_SESSION['flyers'][$i], $pdf, $flyer_lang, true);
			else if ($_SESSION['flyers'][$i]['pagetype'] == 1)
				print_flyer_page_type_1($_SESSION['flyers'][$i], $pdf, $flyer_lang, true);
		/*	
			if (is_file('../saved_flyers/' . $_SESSION['flyer_title'] . '/oldal_' . $i . '_' . $flyer_lang . '.pdf'))
				unlink('../saved_flyers/' . $_SESSION['flyer_title'] . '/oldal_' . $i . '_' . $flyer_lang . '.pdf');        
			
			$pdf->Output('../saved_flyers/' . $_SESSION['flyer_title'] . '/oldal_' . $i . '_' . $flyer_lang . '.pdf', 'F');
			chmod('../saved_flyers/' . $_SESSION['flyer_title'] . '/oldal_' . $i . '_' . $flyer_lang . '.pdf', 0777);
		*/
			unset($pdf);
		}
        //lo-res
        $pdf = new PDF_With_Barcode('P', 'mm', 'A4');
		for ($i = 0; $i < $c; $i++)
		{
			if ($_SESSION['flyers'][$i]['pagetype'] == 0)
				print_flyer_page_type_0($_SESSION['flyers'][$i], $pdf, $flyer_lang);
			else if ($_SESSION['flyers'][$i]['pagetype'] == 1)
				print_flyer_page_type_1($_SESSION['flyers'][$i], $pdf, $flyer_lang);
		}
        if (is_file('../saved_flyers/' . $_SESSION['flyer_title'] . '/email_' . $flyer_lang . '.pdf'))
            unlink('../saved_flyers/' . $_SESSION['flyer_title'] . '/email_' . $flyer_lang . '.pdf');        
        
        $pdf->Output('../saved_flyers/' . $_SESSION['flyer_title'] . '/email_' . $flyer_lang . '.pdf', 'F');
        chmod('../saved_flyers/' . $_SESSION['flyer_title'] . '/email_' . $flyer_lang . '.pdf', 0777);
        unset($pdf);
       
        
        
		redirect_in_site("saved_flyers/" . $_SESSION['flyer_title']);
    }
    else
	{
		$c = $_SESSION['flyers']['pagecount'];
		$pdf = new PDF_With_Barcode('P', 'mm', 'A4');
	  
		for ($i = 0; $i < $c; $i++)
		{
			if ($_SESSION['flyers'][$i]['pagetype'] == 0)
				print_flyer_page_type_0($_SESSION['flyers'][$i], $pdf, $flyer_lang);
			else if ($_SESSION['flyers'][$i]['pagetype'] == 1)
				print_flyer_page_type_1($_SESSION['flyers'][$i], $pdf, $flyer_lang);
		}
		$pdf->Output();
	}
  }
?>