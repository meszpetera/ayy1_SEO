<?php
  include_once("common.php");
  include_once("fpdf_with_barcode.php");
    
  $pdf=new PDF_With_Barcode('P', 'mm', 'A4');
  
    $mysql = get_connection();  
    $result = array();  
    $mysql->execute($sql['setutf']);
    
    $__ids = array('220, 214, 215, 224, 256, 258, 260, 261, 264, 265, 266, 272, 273, 229, 219, 217, 288, 274, 279, 282, 283, 284, 285, 286, 287, 473, 524, 295, 296, 474, 427, 418, 376, 393, 394, 111, 107, 424, 97, 433, 428, 429, 430, 431, 392, 432, 420, 445',
'444, 451, 450, 280, 119, 452, 453, 91, 529, 472, 476, 475, 422, 423, 50, 51, 470, 502, 419, 132, 464, 463, 421, 14, 491, 530, 722, 537, 528, 523, 522, 511, 389, 504, 114, 118, 207, 507, 237, 501, 298, 525, 521, 223, 238, 259, 252, 443, 554' ,
'555, 564, 553, 520, 518, 481, 155, 154, 22, 79, 38, 218, 317, 519, 503, 41, 80, 531, 27, 565, 567, 566, 568, 569, 570, 571, 575, 576, 580, 584, 596, 586, 587, 588, 723, 196, 772, 593, 594, 592, 591, 590, 589, 583, 582, 581, 505, 465, 492',
'374, 646, 634, 648, 493, 506, 157, 289, 291, 649, 650, 651, 654, 778, 662, 663, 664, 666, 667, 668, 669, 670, 671, 672, 780, 86, 87, 336, 337, 338, 339, 208, 602, 603, 604, 247, 248, 457, 458, 460, 461, 462, 684, 685, 686, 144, 688, 693, 694' ,
'695, 696, 697, 698, 699, 700, 701, 702, 703, 642, 643, 383, 15, 16, 17, 608, 609, 533, 689, 690, 691, 692, 730, 731, 733, 734, 735, 741, 516, 517, 742, 490, 618, 610, 147, 719, 162, 782, 31, 36, 43, 44, 45, 46, 47, 635, 761, 257, 728, 729, 661' ,
'725, 171, 172, 173, 174, 658, 659, 660, 136, 137, 290, 152, 747, 748, 732, 727, 632, 633, 621, 622, 623, 624, 625, 758, 759, 760, 714, 371, 372, 373, 763, 764, 765, 146, 720, 230, 231, 232, 233, 762, 513, 514, 234, 235, 236, 787, 788, 789, 177, 178' ,
'179, 262, 263, 606, 607, 539, 139, 1939, 597, 598, 757, 756, 724, 721, 148, 800, 510, 508, 480, 447, 1178, 1176, 1177, 1179, 1180, 1181, 1182, 1183, 1184, 1185, 1186, 1263, 1306, 1312, 1313, 1314, 1281, 478, 479, 1285, 1286, 1278, 1279, 1280, 324, 330' ,
'331, 1296, 434, 435, 437, 1292, 198, 199, 200, 611, 612, 613, 614, 267, 268, 269, 270, 1295, 440, 441, 442, 28, 29, 30, 1299, 540, 546, 547, 1300, 636, 637, 638, 639, 640, 1290, 715, 716, 717, 718, 736, 737, 738, 739, 740, 1301, 801, 802, 803, 486' ,
'487, 488, 489, 1304, 275, 276, 277, 72, 73, 482, 483, 484, 485, 512, 1170, 1171, 1368, 709, 710, 711, 1291, 652, 1366, 1305, 1293, 128, 1364, 1363, 1309, 1310, 1311, 572, 573, 574, 129, 56, 57, 58, 59, 556, 557, 558, 559, 678, 779, 620, 399, 400',
'402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 541, 542, 543, 544, 545, 180, 181, 182, 35 , 76 , 32, 33 , 34 , 3, 75 , 1369, 167, 168, 169, 170, 548, 549, 550, 551, 325, 326, 327, 328, 329, 243, 244, 245, 246, 303, 304, 305',
'306, 307, 401, 9, 10, 11 , 1367, 560, 561, 1375, 1391, 1392, 1393, 1394, 1537, 1897, 1898, 1899, 1900, 1901, 1902, 1903, 1904, 1905, 1906, 1907, 1908, 1932, 1933, 1934, 1944, 1945, 1946, 2024, 2025, 2026, 2027, 2028, 2029, 2080, 2081, 2085' ,
'2086, 2087, 2088, 2155, 2195, 2462, 2495, 2496, 2497, 2498, 2502, 2503, 2504, 2505, 2506, 2507, 2508, 2509, 2510, 2512, 2513, 2514, 2518, 2519, 2520, 2521, 2522, 2523, 2524, 2525, 2526, 2527, 2528, 2529, 2530, 2531, 2532, 2546');

    $stmt = $mysql->prepare('SELECT `truck_id`, `truck_saxon-id` FROM `trucks` WHERE `truck_id` IN (' . 
                            $__ids[$_REQUEST['start']]
                            . ') ORDER BY `truck_saxon-id` ASC');

    if($stmt->execute())
    {
        $result = $stmt->fetch_all();

        foreach ($result as $key => $value)
        { 
                
            $truck = get_truck_details($value['truck_id']);
            $truck = $truck[0];

            $pdf->AddPage();
            $pdf->Image("../img/flyer/flyer_header2.jpg", 3, 3, 204, 20);
            $pdf->Cell(35, 25); $pdf->Ln();

            $pdf->SetFont('Arial', 'B', 20);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(30, 0, $truck['truck_saxon-id']); $pdf->Ln();
            $pdf->Cell(30, 2); $pdf->Ln();


            $pdf->SetFont('Arial', 'B', 60);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Text(120, 275, $truck['truck_saxon-id']);

            if ($truck['truck_state'] == 'E')
            {  
            $pdf->SetFont('Arial', 'B', 40);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Text(130, 225, "Eladva");
            }

            if ($truck['truck_ispart'] == 0)
            {
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 16); 
            $pdf->Cell(100, 12, $truck['truck_make'] . ' ' . $truck['truck_model']); $pdf->Ln();
            }
            else
            {
            $pdf->SetTextColor(160, 160, 160);
            $pdf->SetFont('Arial', '', 16); 
            $pdf->Cell(100, 12, iconv("UTF-8", "ISO-8859-2", $truck['truck_type'])); $pdf->Ln();

            $pdf->SetFont('Arial', '', 12); 
            $pdf->SetTextColor(160, 160, 160);
            $pdf->Cell(100, 0, $truck['truck_make'] . ' ' . $truck['truck_model']); $pdf->Ln();
            }

            $pdf->SetTextColor(0, 0, 0);  

            $pdf->Code39(140, 33, $truck['truck_saxon-id']);
            $pdf->Cell(30, 14); $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_type'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['truck_type']), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_status'] . ':'));
            $pdf->MultiCell(60, 7, iconv("UTF-8", "ISO-8859-2", $truck['truck_status']), 0, 'L');     
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_fuel'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_fuel']), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-load'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_max-load']) . ' kg', 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_max-height'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_max-height']), 0, 'L');  
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_powered-wheel'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_powered-wheel']), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_steered-wheel'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_steered-wheel'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_engine'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_engine'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_drivetrain'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_drivetrain'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_hours-used'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_hours-used'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_year'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_year'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_serial'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_serial'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_weight'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_weight'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_forks'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_forks'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_extras'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_extras'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_comment'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_desc'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_warranty'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_warranty'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_expected-arrival'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", trim($truck['truck_expected-arrival'])), 0, 'L');
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_location'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_location']), 0, 'L');     
            $pdf->Cell(83, 7, "");

            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_cost'] . ':'));
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_cost'] . " EUR" . $language['truck-details_cost-VAT']), 0, 'L');


            if (special_offer_active($truck))
            {
            $pdf->Cell(83, 7, "");
            $pdf->Cell(44, 7, iconv("UTF-8", "ISO-8859-2", $language['truck-details_special_offer_cost'] . ':'));
            $pdf->SetTextColor(255, 0, 0);
            $pdf->MultiCell(60, 7,  iconv("UTF-8", "ISO-8859-2", $truck['truck_special-offer-price'] . " EUR" . $language['truck-details_cost-VAT']), 0, 'L');
            }


            $c = get_image_count($value['truck_id']);


            $defaultimg = get_truck_default_image($value['truck_id']);
            if (is_file("../img/trucks/" . $defaultimg))
            {
            $pdf->Image("../img/trucks/" . $defaultimg, 10, 60, 80);
            }

            $col = 0;
            $vdelta = 0;
            $v = 0;
            for ($i = 0; $i < $c; $i++)
            {
                $img = get_truck_image($truck['truck_id'], $i);

                if ($img != $defaultimg)
                {
                  if (is_file('../img/trucks/' . $img))
                  {
                    $imgsize = getimagesize("../img/trucks/" . $img);
                    $ratio = 38 / $imgsize[0];
                    
                    if (($ratio*$imgsize[1] + 130 + $vdelta) < 280)
                      $pdf->Image("../img/trucks/" . $img, 10 + ($col%2)*40, 130 + $vdelta, 38);
                    
                    
                    if (($col%2 == 0) || ($ratio*$imgsize[1] > $v))
                      $v = $ratio*$imgsize[1];
                    if ($col%2 == 1)
                      $vdelta += $v + 2;
                  }
                    
                  $col++;
                }
            }
        }
  
    }
    else print('shit');
    $pdf->Output();
?>