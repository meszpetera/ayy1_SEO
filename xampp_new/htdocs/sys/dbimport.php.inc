<?php
  include_once("common.php");

    
  $mysql = get_connection();
  $mysql->execute($sql['setutf']);
  $stmt = $mysql->prepare("SELECT * FROM `targoncak` LIMIT 1 OFFSET " . $_REQUEST['row']);
    
  if($stmt->execute())
  {
    $result = $stmt->fetch_all();

    $saxonszam = $result[0]['saxonszam'];
    
    $stmt = $mysql->prepare("SELECT * FROM `truck_make` WHERE `value` = '" . $result[0]['gyartmany'] . "'");
    if($stmt->execute())
      $gyartmany = $stmt->fetch_all();
    if (!isset($gyartmany) || $gyartmany[0]['ID'] == '')
    {
      print('<span style="color:#900;font-weight:bold;">ERROR @ row ' . $_REQUEST['row'] . ' (' . $saxonszam . '): cannot get truck_make "' . $result[0]['gyartmany'] . '"</span>');
      return 0;
    }
    
    $stmt = $mysql->prepare("SELECT * FROM `truck_fuel_hun` WHERE `value` = '" . $result[0]['uzemmod'] . "'");
    if($stmt->execute())
      $uzemmod = $stmt->fetch_all();
    if (!isset($uzemmod) || $uzemmod[0]['ID'] == '')
    {
      print('<span style="color:#900;font-weight:bold;">ERROR @ row ' . $_REQUEST['row'] . ' (' . $saxonszam . '): cannot get truck_fuel "' . $result[0]['uzemmod'] . '"</span>');
      return 0;
    }    
    
    $stmt = $mysql->prepare("SELECT * FROM `truck_status_hun` WHERE `value` = '" . $result[0]['allapot'] . "'");
    if($stmt->execute())
      $allapot = $stmt->fetch_all();
    if (!isset($allapot) || $allapot[0]['ID'] == '')
    {
      print('<span style="color:#900;font-weight:bold;">ERROR @ row ' . $_REQUEST['row'] . ' (' . $saxonszam . '): cannot get truck_status "' . $result[0]['allapot'] . '"</span>');
      return 0;
    }
    
    $stmt = $mysql->prepare("SELECT * FROM `truck_type_hun` WHERE `value` = '" . $result[0]['fajta'] . "'");
    if($stmt->execute())
      $fajta = $stmt->fetch_all();
    if (!isset($fajta) || $fajta[0]['ID'] == '')
    {
      print('<span style="color:#900;font-weight:bold;">ERROR @ row ' . $_REQUEST['row'] . ' (' . $saxonszam . '): cannot get truck_type "' . $result[0]['fajta'] . '"</span>');
      return 0;
    }
    
    $comment = explode('<br />', nl2br($result[0]['megjegyzes'])); 
    
    $t = $result[0]['tarolas'];
    $x = 0;
    $y = 0;
    
    if ($t == 'Vecsés 1') { $x = 1; $y = 0; }
    if ($t == 'VECSÉS') { $x = 1; $y = 0; }
    else if ($t == 'Vecsés 2') { $x = 2; $y = 0; }
    else if ($t == 'Felújító, bontó') { $x = 3; $y = 0; }
    else if ($t == 'Felújító, bontó') { $x = 4; $y = 0; }
    else if ($t == 'Pécs') { $x = 5; $y = 0; }
    else if ($t == 'Eger') { $x = 6; $y = 0; }
    else if ($t == 'bérbeadva') { $x = 7; $y = 0;} 
    else if ($t == 'Nyíregyháza') { $x = 8; $y = 0; }
    else if ($t == 'Győr') { $x = 9; $y = 0; }
    
    else if ($t == 'Vecsés 1 H.SZ.T.') { $x = 1; $y = 1; }
    else if ($t == 'Vecsés 1 MÜHELY') { $x = 1; $y = 2; }
    else if ($t == 'Vecsés 1 U.T.F.') { $x = 1; $y = 3; }
    else if ($t == 'Vecsés 1 B.T') { $x = 1; $y = 4; }
    else if ($t == 'Vecsés 1 B.T.U') { $x = 1; $y = 5; }
    else if ($t == 'Vecsés 1 GARÁZS') { $x = 1; $y = 6; }
    else if ($t == 'Vecsés 1 ÜLLŐ PESTI ÚT') { $x = 1; $y = 7; }
    else if ($t == 'Vecsés 1 VECSÉS BERCSÉNYI 7.') { $x = 1; $y = 8; }
    else if ($t == 'Vecsés 1 VECSÉS ADY E.') { $x = 1; $y = 9; }
    else if ($t == 'Vecsés 1 BÉRBEADVA') { $x = 1; $y = 10; }
    else if ($t == 'Vecsés 1 U.T.U.') { $x = 1; $y = 11; }
    else if ($t == 'Vecsés 1 Ú.T.R.') { $x = 1; $y = 12; }
    else if ($t == 'Vecsés 1 EL.TÁROLÓ') { $x = 1; $y = 13; }
    else if ($t == 'Vecsés 1 VECSÉS ARANY J. 4.') { $x = 1; $y = 14; }
    else if ($t == 'Vecsés 1 VECSÉS KINIZSI ÚT') { $x = 1; $y = 15; }
    else if ($t == 'Vecsés 1 VECSÉS ANDRÁS 10.') { $x = 1; $y = 16; }
    else if ($t == 'Vecsés 1 SAJÁT') { $x = 1; $y = 17; }
    else if ($t == 'Vecsés 1 GÉPTÁR.') { $x = 1; $y = 18; }
    else if ($t == 'Vecsés 1 U.GY.T.') { $x = 1; $y = 19; }
    else if ($t == 'Vecsés 1 ZZ DD') { $x = 1; $y = 20; }
    else if ($t == 'Vecsés 1 YY F') { $x = 1; $y = 21; }
    else if ($t == 'Vecsés 1 ZZZ') { $x = 1; $y = 22; }
    else if ($t == 'Vecsés 1 SÁTOR') { $x = 1; $y = 23; }
    else if ($t == 'Vecsés 1 ELŐKÉSZÍTŐ') { $x = 1; $y = 24; }
    else if ($t == 'Vecsés 1 SPEC.TAR.') { $x = 1; $y = 25; }
    else if ($t == 'Vecsés 1 PARKOLÓ') { $x = 1; $y = 26; }
    
    else if ($t == 'Székesfehérvár BÉRBEADVA') { $x = 4; $y = 1; }
    else if ($t == 'Pécs BÉRBEADVA') { $x = 5; $y = 1; }
    else if ($t == 'Eger BÉRBEADVA') { $x = 6; $y = 1; }
    
    else if ($t == 'BÉRBEADVA MAL') { $x = 7; $y = 1; }
    else if ($t == 'BÉRBEADVA ERECO') { $x = 7; $y = 2; }
    else if ($t == 'BÉRBEADVA VALAKI') { $x = 7; $y = 3; }
    else if ($t == 'BÉRBEADVA TARGOPLAN') { $x = 7; $y = 4; }
    else if ($t == 'BÉRBEADVA ALCOA') { $x = 7; $y = 5; }
    else if ($t == 'BÉRBEADVA ÉBEN TRADE') { $x = 7; $y = 6; }
    else if ($t == 'BÉRBEADVA CONTIREX') { $x = 7; $y = 7; }
    else if ($t == 'BÉRBEADVA ALFÖLDITEJ') { $x = 7; $y = 8; }
    else if ($t == 'BÉRBEADVA PRAKTIKER') { $x = 7; $y = 9; }
    else if ($t == 'BÉRBEADVA BUNDI') { $x = 7; $y = 10; }
    else if ($t == 'BÉRBEADVA METELUX') { $x = 7; $y = 11; }
    else if ($t == 'BÉRBEADVA ZOLTEK') { $x = 7; $y = 12; }
    else if ($t == 'BÉRBEADVA METALUX') { $x = 7; $y = 13; }
    else if ($t == 'BÉRBEADVA ARMADILÓ') { $x = 7; $y = 14; }
    else if ($t == 'BÉRBEADVA TEXEPIL') { $x = 7; $y = 15; }
    
    //print("[x: $x, y: $y, z: '$t'] "); 
    
    $insert = "INSERT INTO `trucks` (`truck_id` ,`truck_saxon-id` ,`truck_make` ,`truck_model` ,`truck_fuel` ,`truck_max-load` ,`truck_max-height` ,`truck_status` ,`truck_type` ,`truck_cost` ,`truck_rent` ,`truck_date` ,`truck_reserved` ,`truck_special-offer-active` ,`truck_special-offer-start` ,`truck_special-offer-end` ,`truck_special-offer-price` ,`truck_default-image` ,`truck_powered-wheel` ,`truck_steered-wheel` ,`truck_engine` ,`truck_drivetrain` ,`truck_hours-used` ,`truck_year` ,`truck_serial` ,`truck_weight` ,`truck_extras` ,`truck_desc` ,`truck_internal-desc` ,`truck_depot` ,`truck_sub-depot`, `truck_state`) VALUES (NULL ," . 
              "'" . $saxonszam  . "' ," . 
              "'" . $gyartmany[0]['ID']  . "' ," . 
              "'" . $result[0]['tipus']  . "' ," . 
              "'" . $uzemmod[0]['ID']  . "' ," . 
              "'" . $result[0]['teherbiras']  . "' ," . 
              "'" . $result[0]['emelmag']  . "' ," . 
              "'" . $allapot[0]['ID']  . "' ," . 
              "'" . $fajta[0]['ID']  . "' ," . 
              "'" . $result[0]['ar']  . "' ," . 
              "'" . $result[0]['ber']  . "' ," . 
              "'" . $result[0]['date']  . "' ," . 
              "'" . $result[0]['foglalt']  . "' ," . 
              "'0' ,'2000-01-01' ,'2000-01-01' ,'0' ,'0' ," . 
              "'" . $comment[0] . "' ," .//powered wheel
              "'" . $comment[1] . "' ," .
              "'" . $comment[2] . "' ," .
              "'" . $comment[3] . "' ," .
              "'" . $comment[4] . "' ," .
              "'" . $comment[5] . "' ," .
              "'" . $comment[6] . "' ," .
              "'" . $comment[7] . "' ," .
              "'" . $comment[8] . "' ," .
              "'" . $comment[9] . "' ," .
              "'" . "" . "' ," .
              "'" . $x . "' ," .
              "'" . $y . "', 'A');";
              //print($insert);
             
    $stmt = $mysql->prepare($insert);
    if($stmt->execute()) 
    {//exists
	  if(file_exists("../img/trucks/".$result[0]['saxonszam'] . ".jpg"))
	  {
      $stmt = $mysql->prepare("SELECT LAST_INSERT_ID()");
      $stmt->execute();
      $lastid = $stmt->fetch_all();

      $stmt = $mysql->prepare("INSERT INTO `truck_images` (`image_unique-id`, `image_truck-id`, `image_id`, `image_filename`) VALUES ('', '" . $lastid[0]['LAST_INSERT_ID()'] . "', '0', '" . $result[0]['saxonszam'] . ".jpg')");
      $stmt->execute();
	  }
    }/**/
  }

  //print('<span style="color:#090;font-weight:bold;">SUCCESS @ row ' . $_REQUEST['row'] . ': row imported with ID of ' . $lastid[0]['LAST_INSERT_ID()'] . '</span>');


?>