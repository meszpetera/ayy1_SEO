<?php

include_once("common.php");
include_once("fpdf_with_barcode.php");
// exit($lang);
error_reporting(0);
if (isauth() && isset($_REQUEST['offerid'])) {
    $offer = get_offer_request($_REQUEST['offerid']);
    $offer_language = $offer['offer_data']['offer_lang'];

    //we have to override the language here
    if (isset($offer_language) && lang_exists($offer_language)) {
        $lang = $offer_language;
    } else {
        $lang = 'hun';
    }
    include("lang/" . $lang . "/language.php");




    $offer = get_offer_request($_REQUEST['offerid']); // @TODO a nyelvnek nem szabadna a rekord betöltését befolyásolnia!
//    print($offer['offer_data']['offer_status']);
    if (($offer['offer_data']['offer_status'] == 4) || ($offer['offer_data']['offer_status'] == 1) || ($offer['offer_data']['offer_status'] == 2)) {
        $moneyKind = (($offer['offer_data']['offer_euro'] != 0) ? " HUF" : " EUR");

        if ("***" . $offer['offer_data']['offer_date-closed'] . "***" != "***0000-00-00 00:00:00***") {
            $offerID_Fancy = substr($offer['offer_data']['offer_date-closed'], 2, 2) . str_pad($offer['offer_data']['offer_id'], 4, '0', STR_PAD_LEFT);
        } else {
            $offerID_Fancy = date("y") . str_pad($offer['offer_data']['offer_id'], 4, '0', STR_PAD_LEFT);
        }


        $pdf = new PDF_With_Barcode('P', 'mm', 'A4');
        //$mysql = get_connection();
        //$mysql->execute($sql['setutf']);

        $pdf->AddPage();
        $pdf->Image($language['offer_pdf_data']['headerimage'], 3, 3, 204, 20);
        $pdf->Cell(35, 25);
        $pdf->Ln();

        $pdf->SetFont('Arial', 'b', 10);
        $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $offer['userdata']['company_name']));
        $pdf->Ln();
        $pdf->Cell(30, 10);
        $pdf->Ln();

        $addr = "";
        if ($offer['userdata']['company_city'] != "")
            $addr = $offer['userdata']['company_city'] . ', ' . $offer['userdata']['company_address'];
        else
            $addr = $offer['userdata']['company_address'];


        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $addr));
        $pdf->Ln();
        $pdf->Cell(30, 5);
        $pdf->Ln();

        /* $pdf->Cell(30, 0, '{$address-line-2}'); $pdf->Ln();
          $pdf->Cell(30, 5); $pdf->Ln(); */
        $countryInfo = GetCountry($offer['userdata']['company_country']);
        $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $countryInfo[0]['country_prefix'] . $offer['userdata']['company_zip']));
        $pdf->Ln();
        $pdf->Cell(30, 10);
        $pdf->Ln();

//                                           $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['contact_point']) . 
//                                           /*ember telszáma kell ide*/utf8_decode(fix_phone_number($offer['userdata']['company_phone'], $offer['userdata']['company_country'])) . ', ' . 
//                                           $offer['userdata']['users_email'] . 
//                                           (($offer['userdata']['company_phone'] != $offer['userdata']['users_phone']) 
//                                            ? ', ' . fix_phone_number($offer['userdata']['users_phone'], $offer['userdata']['company_country'])
//                                            : '')); 
//                                           $pdf->Cell(30, 5); $pdf->Ln();

        $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['date']) . $offer['offer_data']['offer_date-added']);
        $pdf->Ln();
        $pdf->Cell(30, 7);
        $pdf->Ln();

        $pdf->SetFont('Arial', 'b', 10);
        $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['ID']) . $offerID_Fancy);
        $pdf->Ln();
        $pdf->Cell(30, 5);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_1']));
        $pdf->SetFont('Arial', 'b', 10);
        $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $offer['userdata']['users_realname']));

//      $pdf->SetFont('Arial', '', 10);      $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", ' (' . $offer['userdata']['users_phone'] . ', ' . $offer['userdata']['users_email'] . ')'));
        $pdf->SetFont('Arial', '', 10);
        $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_2']));
        $pdf->Ln();
        $pdf->SetFont('Arial', 'b', 10);
        $pdf->Cell(30, 5);
        $pdf->Ln();
        $pdf->Cell(30, 0, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['contact_point']) .
                /* ember telszáma kell ide */utf8_decode(fix_phone_number($offer['userdata']['company_phone'], $offer['userdata']['company_country'])) . ', ' .
                $offer['userdata']['users_email'] .
                (($offer['userdata']['company_phone'] != $offer['userdata']['users_phone']) ? ', ' . fix_phone_number($offer['userdata']['users_phone'], $offer['userdata']['company_country']) : ''));
        $pdf->Cell(30, 5);
        $pdf->Ln();




        $pdf->SetFont('Arial', '', 10);
        $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_3']));
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('Arial', 'b', 12);
        foreach ($offer['trucks'] as $truck) {
            $pdf->Write(5, '        ' . iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_make']) . ' ' . $truck['offer_truck_model'] . ', ' . utf8_decode($truck['offer_truck_status']) . ', ' . $truck['offer_truck_cost'] . $moneyKind);
            $pdf->Ln();
        }

        //$pdf->Write(5, '        {$truck_make} {$truck_model}, {$truck_status}'); $pdf->Ln();
        $pdf->Ln();
        $f = (int) ($offer['offer_data']['offer_payment']);
        $f2 = (int) ($offer['offer_data']['offer_deliverymethod']);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 7, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['payment']));
        $pdf->MultiCell(140, 7, utf8_decode($language['paymodes'][(int) $f]));
        $pdf->Cell(30, 7, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['advance']));
        $pdf->MultiCell(140, 7, $offer['offer_data']['offer_reserve'] . "%");
        $pdf->Cell(30, 7, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['deadline']));
        $pdf->MultiCell(140, 7, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['specified_on_product_pages']));
        $pdf->Cell(30, 7, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['delivery']));
        $pdf->MultiCell(140, 7, utf8_decode($language['deliverymethods'][(int) $f2]));

        $pdf->Cell(30, 5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['warranty']));
        $pdf->MultiCell(140, 5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['warranty_disclaimer']));
        $pdf->Ln();

        $msg = iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_4.1'] . $offer['offer_data']['offer_lifetime'] . $language['offer_pdf_data']['Text_4.2']);
        if ($offer['offer_data']['offer_euro'] != 0)
            $msg .= iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_5:EUR_rate_pre']) . $offer['offer_data']['offer_euro'] . iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_5:EUR_rate_post']);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Write(5, $msg);
        $pdf->Ln();
        $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['attachment_count_pre']) . count($offer['trucks']) . iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['attachment_count_post']));
        $pdf->Ln();
        $pdf->Ln();

        if ($offer['offer_data']['offer_comment'] != "") {
            //exit(iconv("UTF-8", "Latin2",$offer['offer_data']['offer_comment']));
            $pdf->SetFont('Arial', 'b', 10);
            $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['comments']));
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 10);
            $pdf->Write(5, iconv("UTF-8", "Latin2", $offer['offer_data']['offer_comment']));
            $pdf->Ln();
            $pdf->Ln();
        }
        $pdf->SetFont('Arial', 'b', 10);
        $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Text_6']));
        $pdf->Ln();
        $pdf->Ln();

        if ("***" . $offer['offer_data']['offer_date-closed'] . "***" != "***0000-00-00 00:00:00***") {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", 'Vecsés, ' . $offer['offer_data']['offer_date-closed']));
            $pdf->Ln();
            $pdf->Ln();
        } else {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Write(5, iconv("UTF-8", "ISO-8859-2", 'Vecsés, ' . date('Y. M. d. G:i')));
            $pdf->Ln();
            $pdf->Ln();
        }

        $pdf->Cell(90, 5, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['Sig_1']));
        // $pdf->Ln();
        switch ($offer['offer_data']['offer_signature']) {
            case 1:
                $sign = "Szász Attila";
                $phonen = "+36-30-934-1152";
                break;
            case 2:
                $sign = "Nagy Attila";
                $phonen = "+36-30-684-2897";
                break;
            case 3:
                $sign = "Eftimie Dorin";
                $phonen = "+36-30-815-5997";
                break;
            default:
                $sign = "Szász Imre";
                $phonen = "+36-30-931-6569";
                break;
        }

        // $pdf->MultiCell(100, 5, utf8_decode($offer['clerkdata']['users_realname']), '', 'C');
        $pdf->MultiCell(100, 8, iconv("UTF-8", "ISO-8859-2", $sign . "\n\r" . $phonen), '', 'C');
        //$pdf->MultiCell(100, 5, $phonen, '', 'C');

        $pdf->SetFont('Arial', '', 14);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(180, 10, iconv("UTF-8", "ISO-8859-2", $language['offer_pdf_data']['details_next_page']), '', 'C');

        $pdf->MultiCell(0, 20, $pdf->Image('../img/red_down_arrow.jpg', /* $pdf->GetX() */ 100, $pdf->GetY(), 10, 10), '', 'C');


        $pdf->SetTextColor(0, 0, 0);



        foreach ($offer['trucks'] as $truck) {
            $pdf->AddPage();
            $pdf->Image("../img/flyer/flyer_header.jpg", 3, 3, 204, 20);
            $pdf->Cell(35, 25);
            $pdf->Ln();

            $pdf->SetFont('Arial', 'B', 20);
            if ($truck['offer_truck_saxon-id'] == '')
                $saxonid = iconv("UTF-8", "ISO-8859-2", $language['truck-details_not-in-stock']);
            else
                $saxonid = $truck['offer_truck_saxon-id'];
            $pdf->Cell(30, 0, $saxonid);
            $pdf->Ln();
            $pdf->Cell(30, 4);
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 16);
            //$pdf->Cell(100,12, iconv("UTF-8","ISO-8859-2",$truck['offer_truck_make'].' '.$truck['offer_truck_model']) );
            $pdf->MultiCell(120, 7, wordwrap(iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_make'] . ' ' . $truck['offer_truck_model']), 40));
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(160, 160, 160);
            $pdf->Cell(100, 0, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_type']));
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);

            if ($truck['offer_truck_saxon-id'] != "") {
                $pdf->Code39(140, 33, $truck['offer_truck_saxon-id']);
            }
            $pdf->Cell(30, 14);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);

            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_status'] . ':'));
            $pdf->MultiCell(70, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_status']), 0, 'L');

            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_function'] . ':'));
            $pdf->MultiCell(70, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_function']), 0, 'L');

            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_fuel'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_fuel']), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-height'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_max-height']), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-load'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_max-load']) . ' kg', 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_location'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_location']), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_powered-wheel'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_powered-wheel']), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_steered-wheel'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_steered-wheel'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_engine'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_engine'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_drivetrain'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_drivetrain'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_hours-used'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_hours-used'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_year'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_year'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_serial'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_serial'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_weight'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_weight'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_extras'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_extras'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_warranty'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_warranty'])), 0, 'L');
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_expected-arrival'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_expected-arrival'])), 0, 'L');

            if ($truck['offer_truck_vtsz'] != "") {
                $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", 'VTSZ:'));
                $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_vtsz'])), 0, 'L');
            } else {
                $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", 'VTSZ:'));
                $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", trim('84272019')), 0, 'L');
            }




            $pdf->Ln();
            $pdf->Ln();

            if ($truck['offer_truck_ocomment'] != "") {
                // exit("f");
                $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['aktualis_offersummary:comment']));
                $pdf->MultiCell(0, 7, iconv("UTF-8", "ISO-8859-2", trim($truck['offer_truck_ocomment'])), 0, 'L');
                //$pdf->Write(7, iconv("UTF-8", "Latin2", $truck['offer_truck_ocomment']));
            }
            $count = 0;

            //---[ price ]---------------------------------------------------------
            $pdf->SetXY(80, 250);
            $pdf->SetFont('Arial', '', 32);
            $pdf->SetTextColor(255, 0, 0);

            //$pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_cost'] . ':'));
            $pdf->MultiCell(120, 9, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_cost'] . $moneyKind . $language['truck-details_cost-VAT']), 0, 0, 'R');

            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            if ($truck['offer_truck_fake-image'] == '1') {
                $pdf->SetXY(119, 63);
                $pdf->Cell(60, 7, iconv("UTF-8", "ISO-8859-2", $language['aktualis_offersummary:fake-image']));
            } else if($truck['offer_truck_fake-image']) {
                $pdf->SetXY(119, 63);
                $pdf->Cell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['offer_truck_fake-image']));
            }


            for ($i = 0; $i < count($truck['images']) && $count < 2; $i++) {
                $img = "../img/trucks_copy/" . $_REQUEST['offerid'] . "/" . $truck['images'][$i]['offer_image_filename'];
                //   print($img);
                // $img = ($img == "") ? "../img/trucks/truck_hires.jpg" : "../img/trucks/" . $img;
                if (is_file($img) && $truck['images'][$i]['offer_image_enabled']) {
                    $pdf->Image($img, 120, 60 + (($truck['offer_truck_fake-image']) ? 10 : 0) + 70 * $count, 80);
                    $count++;
                }
            }
            if ($count == 0) {
                // $img = "../img/trucks/truck_hires.jpg";
                // $pdf->Image($img,60, 150, 80);
            }
        }



        if (isset($_REQUEST['sendEmail'])) {

            //var_dump( mail('ajanlat@saxonrt.hu', 'teszt', 'hello', 'From: saxonrt@saxonrt.hu') );

            $saved_offer_path = "../saved_offers/saxon - $offerID_Fancy.pdf";
            $pdf->Output($saved_offer_path, "F");

            $email_from = "saxonrt@saxonrt.hu"; // Who to email this from
            $email_subject = "Árajánlat"; // The Subject of the email
            $email_messagecontent = $language['offer_pdf_data']['email_text']; // Message that the email has in it
            $email_to = 'ajanlat@saxonrt.hu, saxonrt@t-online.hu, ' . $offer['userdata']['users_email']; // Who the email is to
            //$email_to = 'istvan.farmosi@gmail.com';
            $headers = "From: " . $email_from . "\n";
            $headers.="User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20111105 Thunderbird/8.0\n";
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

            $headers .= "MIME-Version: 1.0\n" .
                    "Content-Type: multipart/mixed;\n" .
                    " boundary=\"{$mime_boundary}\"";
            // @TODO $email_message includes itself in this value
            $email_message .= "This is a multi-part message in MIME format.\n\n" .
                    "--{$mime_boundary}\n" .
                    "Content-Type: text/html; charset=ISO-8859-2\n" .
                    "Content-Transfer-Encoding: 8bit\n\n" .
                    $email_messagecontent . "\n\n";

            //offer pdf
            $fileatt = $saved_offer_path; // Path to the file
            $fileatt_type = "application/octet-stream"; // File Type
            $fileatt_name = ($offer_language == 'hun') ? "arajanlat.pdf" : "offer.pdf"; // Filename that will be used for the file as the attachment

            $file = fopen($fileatt, 'rb');
            $data = fread($file, filesize($fileatt));
            fclose($file);

            $data = chunk_split(base64_encode($data));

            $email_message .= "--{$mime_boundary}\n" .
                    "Content-Type: {$fileatt_type};\n" .
                    " name=\"{$fileatt_name}\"\n" .
                    "Content-Disposition: attachment;\n" .
                    " filename=\"{$fileatt_name}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data . "\n" .
                    "--{$mime_boundary}\n";

            //flyer pdf
            $mysql = get_connection();
            $mysql->execute($sql['setutf']);
            $stmt = $mysql->prepare($sql['flyer_getemail']);
            $stmt->execute();
            $result = $stmt->fetch_all();

            /*
              $fileatt = '../saved_flyers/' . $result[0]['value'] . '/email_' . $offer_language . '.pdf'; // Path to the file
              $fileatt_type = "application/octet-stream"; // File Type
              $fileatt_name = ($offer_language == 'hun') ? "prospektus.pdf" : "flyer.pdf"; // Filename that will be used for the file as the attachment

              $file = fopen($fileatt, 'rb');
              $data = fread($file, filesize($fileatt));
              fclose($file);

              $data = chunk_split(base64_encode($data));

              $email_message .= //"--{$mime_boundary}\n".
              "Content-Type: {$fileatt_type};\n" .
              " name=\"{$fileatt_name}\"\n" .
              "Content-Disposition: attachment;\n" .
              " filename=\"{$fileatt_name}\"\n" .
              "Content-Transfer-Encoding: base64\n\n" .
              $data . "\n" .
              "--{$mime_boundary}--";
             */

            unset($data);
            unset($file);
            unset($fileatt);
            unset($fileatt_type);
            unset($fileatt_name);


            error_reporting(E_ALL);
            $ok = mail($email_to, '=?UTF-8?B?' . base64_encode($email_subject) . '?=', $email_message, $headers);
            //$ok2 = mail('ajanlat@saxonrt.hu', '=?UTF-8?B?' . base64_encode($email_subject) . '?=', $email_message, $headers);
            //$ok = @mail('istvan.farmosi@gmail.com', '=?ISO8859-2?B?'.base64_encode($email_subject).'?=', $email_message, $headers);
            //$ok = mail('istvan.farmosi@gmail.com', 'test', 'test', 'From: lol@saxonrt.hu\nReply-To:istvan.farmosi@pubverse.eu');
            if ($ok) {
                echo "<HTML><HEAD><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"></HEAD><BODY>";
                echo "<font face=verdana size=2>Az ajánlat a \"$email_to\" címre el lett küldve.</font><BR><BR>";
                echo "Visszatérhet a <A HREF=\"/?page=admin&lang=hun\">Főmenübe</A>, vagy megtekintheti az <A HREF=\"/?page=offer_requests&offerID=" . $offer['offer_data']['offer_id'] . "\">ajánlatot</A><BR><BR>";

                echo "</BODY></HTML>";
                close_offer_request($_REQUEST['offerid']);
            } else {
                echo "<HTML><HEAD><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"></HEAD><BODY>";
                echo("<font face=verdana size=2>Az ajánlat kézbesitese a(z) \"$email_to\" címre sikertelen volt.</font>");
                echo "Visszatérhet a <A HREF=\"/?page=admin&lang=hun\">Főmenübe</A>, vagy megtekintheti az <A HREF=\"/?page=offer_requests&offerID=" . $offer['offer_data']['offer_id'] . "\">ajánlatot</A><BR><BR>";
                echo "</BODY></HTML>";
                die();
            }
        } elseif (isset($savetoclient))
            $pdf->Output("saxon - $offerID_Fancy.pdf", "D");
        else
            $pdf->Output("saxon - $offerID_Fancy.pdf", "I");
    }
}
?>