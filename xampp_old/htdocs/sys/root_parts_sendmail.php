<?php

include_once("common.php");

include ('../recaptcha/recaptchalib.php');
$resp = recaptcha_check_answer($CAPTCHA['private_key'], $_SERVER["REMOTE_ADDR"], $_REQUEST["recaptcha_challenge_field"], $_REQUEST["recaptcha_response_field"]);

if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly


    $_SESSION['pending_alkatreszrendeles'] = array(
        'company' => $_REQUEST['company'],
        'client' => $_REQUEST['client'],
        'tel' => $_REQUEST['tel'],
        'email' => $_REQUEST['email'],
        'truck_type' => $_REQUEST['truck_type'],
        'truck_serial' => $_REQUEST['truck_serial'],
        'truck_year' => $_REQUEST['truck_year'],
        'part' => $_REQUEST['part'],
        'CAPTCHA_ERROR' => $language['reg:captcha_error']
    );

    //print_r($_SESSION['pending_ajanlatkeres']);

    redirect_in_site("?page=root_parts&lang=$lang");
} else {
    // Your code here to handle a successful verification


    include_once("fpdf_with_barcode.php");

    $pdf = new PDF_With_Barcode('P', 'mm', 'A4');

    $pdf->AddPage();
    $pdf->Image($language['offer_pdf_data']['headerimage'], 3, 3, 204, 20);
    $pdf->Cell(35, 25);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'b', 20);
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Alkatrész rendelés"));
    $pdf->Cell(35, 20);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'b', 14);
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Targonca:"));
    $pdf->Cell(35, 10);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'b', 10);
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Targonca típusa:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['truck_type']));
    $pdf->Ln();
    $pdf->Cell(35, 5);
    $pdf->Ln();

    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Gyári szám:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['truck_serial']));
    $pdf->Ln();
    $pdf->Cell(35, 5);
    $pdf->Ln();

    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Évjárat:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['truck_year']));
    $pdf->Ln();
    $pdf->Cell(35, 15);
    $pdf->Ln();


    $pdf->SetFont('Arial', 'b', 14);
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Alkatrészek:"));
    $pdf->Cell(35, 10);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'b', 10);

    /*
      for ($i = 1; $i < 100; $i++) {
      if (($_REQUEST['part' . $i . '_name'] != '') || ($_REQUEST['part' . $i . '_id'] != '')) {
      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $i . '.'));
      $pdf->Cell(35, 5);
      $pdf->Ln();

      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Megnevezés:"));
      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['part' . $i . '_name']));
      $pdf->Ln();
      $pdf->Cell(35, 5);
      $pdf->Ln();
      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Cikkszám:"));
      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['part' . $i . '_id']));
      $pdf->Ln();
      $pdf->Cell(35, 5);
      $pdf->Ln();
      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Darabszám:"));
      $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['part' . $i . '_count']));
      $pdf->Ln();
      $pdf->Cell(35, 10);
      $pdf->Ln();
      }
      }
     * 
     */
    foreach ($_REQUEST['part'] as $k => $v) {
        if ($v['id'] != '') {
            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $k . '.'));
            $pdf->Cell(35, 5);
            $pdf->Ln();

            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Megnevezés:"));
            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $v['name']));
            $pdf->Ln();
            $pdf->Cell(35, 5);
            $pdf->Ln();
            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Cikkszám:"));
            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $v['id']));
            $pdf->Ln();
            $pdf->Cell(35, 5);
            $pdf->Ln();
            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Darabszám:"));
            $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $v['count']));
            $pdf->Ln();
            $pdf->Cell(35, 10);
            $pdf->Ln();
        }
    }


    $pdf->SetFont('Arial', 'b', 14);
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Érdeklődő adatai:"));
    $pdf->Cell(35, 10);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'b', 10);
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Cég neve:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['company']));
    $pdf->Ln();
    $pdf->Cell(35, 5);
    $pdf->Ln();
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Érdeklődő neve:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['client']));
    $pdf->Ln();
    $pdf->Cell(35, 5);
    $pdf->Ln();
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "Telefonszám:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['tel']));
    $pdf->Ln();
    $pdf->Cell(35, 5);
    $pdf->Ln();
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", "EMail cím:"));
    $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $_REQUEST['email']));
    $pdf->Ln();
    $pdf->Cell(35, 5);
    $pdf->Ln();



    $saved_offer_path = "../tmp/" . microtime() . ".pdf";
    $pdf->Output($saved_offer_path, "F");

    $email_from = "noreply@saxonrt.hu"; // Who to email this from 
    $email_subject = "Alkatrészrendelés"; // The Subject of the email 
    $email_message = "A rendelés tartalma a csatolt pdf fájlban található."; // Message that the email has in it 

    $email_to = "saxonrt@t-online.hu"; // Who the email is to 

    $headers = "From: " . $email_from;

    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" .
            "Content-Type: multipart/mixed;\n" .
            " boundary=\"{$mime_boundary}\"";

    $email_message .= "This is a multi-part message in MIME format.\n\n" .
            "--{$mime_boundary}\n" .
            "Content-Type:text/html; charset=\"UTF-8\"\n" .
            "Content-Transfer-Encoding: 8bit\n\n" .
            $email_message . "\n\n";





    $fileatt = $saved_offer_path; // Path to the file 
    $fileatt_type = "application/octet-stream"; // File Type 
    $fileatt_name = "saxon.pdf"; // Filename that will be used for the file as the attachment 

    $file = fopen($fileatt, 'rb');
    $data = fread($file, filesize($fileatt));
    fclose($file);


    $data = chunk_split(base64_encode($data));

    $email_message .= "--{$mime_boundary}\n" .
            "Content-Type: {$fileatt_type};\n" .
            " name=\"{$fileatt_name}\"\n" .
            //"Content-Disposition: attachment;\n" . 
            //" filename=\"{$fileatt_name}\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" .
            $data . "\n\n" .
            "--{$mime_boundary}\n";
    unset($data);
    unset($file);
    unset($fileatt);
    unset($fileatt_type);
    unset($fileatt_name);



    $ok = @mail($email_to, '=?UTF-8?B?' . base64_encode($email_subject) . '?=', $email_message, $headers);

    if ($ok) {
        //echo "<font face=verdana size=2>Ajánlatkérését rögzítettük, munkatársunk hamarosan kapcsolatba lép Önnel a megadott elérhetőségek egyikén.</font>";
        $_SESSION['pending_alkatreszrendeles'] = array(
            'CAPTCHA_ERROR' => 'Ajánlatkérését rögzítettük, munkatársunk hamarosan kapcsolatba lép Önnel a megadott elérhetőségek egyikén.'
        );
        redirect_in_site("?page=root_parts&lang=$lang");
    } else {
        die("Az ajánlatkérés rögzítése során hiba történt, kérem próbálja újra. A kellemetlenségekért elnézését kérjük.");
    }
    //$pdf->Output(microtime() . ".pdf", "I");
}
?>