<?php

    include_once('common.php');
    
    global $sql;

    $makeid   = $_REQUEST['make'];
    $typeid   = $_REQUEST['type'];
    $ispart   = $_REQUEST['ispart'];
    $location = $_REQUEST['location'];
    $betu     = strtoupper($_REQUEST['betu']);
    if (empty($betu)){
        $betu = 'S';
    }

    /************************************/

  	define('DB_HOST', '127.0.0.1');
  	define('DB_USER', 'saxonrt');
  	define('DB_DB', 'saxonrt');
  	define('DB_PASSWORD', 'NwzV6Dc');
  	define('LOGIN_NAME', 'farm');
  	define('LOGIN_PASSWORD', 'ujjelszo');
    define('SAXID', 'truck_saxon-id');
    
  	$link	= @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
  	if( !$link ) {
  		print('Adatbazis csatlakozasi hiba.<br>');
  		exit();
  	} 

  /*H - Villás targoncák
    Y - Fõdarabok
    V - Építõipari gépek
    R - Kézi emelõk
    A - Adapterek
    V - Vontatók, golfautók
    K - Kiegészítõk
    S - Sehová
    M - Emelõszerkezetek, villák
    G - Gumiköpenyek, felnik */

    /*switch ($ispart){
      case 0:
          $betu = 'H';
          break;
      case 1:
          $betu = 'Y';
          break;
      case 2:
          $betu = 'V';
          break;
      case 3:
          $betu = 'R';
          break;
      case 4:
          $betu = 'A';
          break;
      case 5:
          $betu = 'V';
          break;
      case 6:
          $betu = 'K';
          break;
      case 7:
          $betu = 'S';
          break;
      case 8:
          $betu = 'M';
          break;
      case 9:
          $betu = 'G';
          break;
      default:
          $betu = '';
    } */
    // echo 'Ispart: ' . $ispart . ' Betû: '.$betu.' <br>';

    $stmt = "SELECT `truck_saxon-id` FROM trucks WHERE SUBSTRING(`truck_saxon-id`,1,1)='". $betu . "' ORDER BY SUBSTRING(`truck_saxon-id`,1,6) DESC LIMIT 1";
    $result = mysqli_query($link, $stmt);
    $data = mysqli_fetch_assoc($result);
    $sorszam = intval(substr($data["truck_saxon-id"],2,4)) + 1;
    $sorszam = substr('0000'.strval($sorszam), -4);
    $saxonid = $betu . '-' . $sorszam;
    
    /*echo 'Location: '.$location . '<br>';
    $loc = explode('/', $_REQUEST['location']);
    echo 'Loc: '.$loc[0].' - ' . $loc[1].'<br>';
    
    exit();*/
    
    /************************************/

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    /* if (isset($_REQUEST['type_add']) && $_REQUEST['type_add'] != "") {
        $stmt = $mysql->prepare($sql['truckman_get_type_count']);
        $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart']);
        $stmt->execute();
        $c = $stmt->fetch_all();
        if ($c[0]['count'] == 0) {
            //hun and get id
            $stmt = $mysql->prepare($sql['truckman_add_type']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "hun");
            $stmt->execute();
            $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`;");
            $stmt->execute();
            $id = $stmt->fetch_all();
            $typeid = $id[0]['id'];

            //eng
            $stmt = $mysql->prepare($sql['truckman_add_type_id']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "eng", $typeid);
            $stmt->execute();
            //ger
            $stmt = $mysql->prepare($sql['truckman_add_type_id']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "ger", $typeid);
            $stmt->execute();
        } else {
            $stmt = $mysql->prepare($sql['truckman_find_type']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart']);
            $stmt->execute();
            $m = $stmt->fetch_all();
            $typeid = $m[0]['id'];
        }
        echo 'Bejött, typeid:' . $typeid;
    }  */

    /* if (isset($_REQUEST['make_add']) && $_REQUEST['make_add'] != "") {
        $stmt = $mysql->prepare($sql['truckman_get_make_count']);
        $stmt->bind_params($_REQUEST['make_add']);
        $stmt->execute();
        $c = $stmt->fetch_all();
        if ($c[0]['count'] == 0) {
            $stmt = $mysql->prepare($sql['truckman_add_make']);
            $stmt->bind_params($_REQUEST['make_add']);
            $stmt->execute();
            $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`;");
            $stmt->execute();
            $id = $stmt->fetch_all();
            $makeid = $id[0]['id'];
        } else {
            $stmt = $mysql->prepare($sql['truckman_find_make']);
            $stmt->bind_params($_REQUEST['make_add']);
            $stmt->execute();
            $m = $stmt->fetch_all();
            $makeid = $m[0]['id'];
        }
        echo 'Bejött, makeid:' . $makeid;
    }  */

    // $uid = microtime();

    $loc = explode('/', $_REQUEST['location']);

    // $stmt = $mysql->prepare($sql['truckman_add_truck']);

    $cost = 0;
    $rent = 0;
    $reserve = 0;
    $active = 0;
    $offstart = '0000-00-00';
    $offend = '0000-00-00';
    $offprice = 0;
    $image = 0;
    $depot = $loc[0];
    $sdepot = $loc[1];
    $state = 'A';
    $resstart = '0000-00-00';
    $resend = '0000-00-00';
    $ttemp = '';
    $soffer = 0;
    $now = date("Y-m-d");

    /*$stmt->bind_params("", 
          $saxonid, '$makeid', $_REQUEST['function'], $_REQUEST['model'],  $_REQUEST['fuel'],  $_REQUEST['maxload'], $_REQUEST['maxheight'],  $_REQUEST['status'], 
          $typeid, $cost, $_REQUEST['price'],  $rent, $now, $reserve, $active, $offstart, $offend, $offprice,
          $image, $_REQUEST['pwheel'], $_REQUEST['swheel'], $_REQUEST['engine'], $_REQUEST['drivetrain'], $_REQUEST['hours'],  $_REQUEST['year'], $_REQUEST['serial'], $_REQUEST['weight'], $_REQUEST['extras'], 
          $_REQUEST['publicdesc'], $_REQUEST['internaldesc'], $loc[0], $loc[1],$_REQUEST['length'],$_REQUEST['width'],$_REQUEST['turning-circle'],$depot,$sdepot,$state,
          $_REQUEST['warranty'], $_REQUEST['arrival'], $resstart, $resend, $_REQUEST['ispart'], $ttemp, $_REQUEST['shortdesc'], $_REQUEST['forks'],$soffer,$_REQUEST['truck_public'],
          $_REQUEST['seller_name'], $_REQUEST['seller_price'], $_REQUEST['seller_date'], $_REQUEST['seller_invoicenum'],
          $_REQUEST['buyer_name'],  $_REQUEST['buyer_price'],  $_REQUEST['buyer_date'],  $_REQUEST['buyer_invoicenum'], $_REQUEST['truck_prodstat']);

    $stmt->execute();   
    
    echo '<br>Kész.';    

    // print $stmt->result;*/
    
    $mfunction = $_REQUEST['function'];
    
    /*$para = "insert into trucks( 
        `truck_id`,`truck_saxon-id`,`truck_make`,`truck_function`,`truck_model`,`truck_fuel`,`truck_max-load`,`truck_max-height`,`truck_status`,
        `truck_type`,`truck_cost`,`truck_reseller_price`,`truck_rent`,`truck_date`,`truck_reserved`,`truck_special-offer-active`,`truck_special-offer-start`,`truck_special-offer-end`, `truck_special-offer-price`,
        `truck_default-image`,`truck_powered-wheel`,`truck_steered-wheel`,`truck_engine`,`truck_drivetrain`,`truck_hours-used`,`truck_year`,`truck_serial`,`truck_weight`,`truck_extras`,
        `truck_desc`,`truck_internal-desc`,`truck_full-height`,`truck_cabin-height`,`truck_length`,`truck_width`,`truck_lifting-column-height`,`truck_depot`,`truck_sub-depot`,`truck_state`,
        `truck_warranty`,`truck_expected-arrival`,`truck_reserve-start`,`truck_reserve-end`,`truck_ispart`,`truck_temp`,`truck_short-comment`,`truck_forks`,`truck_auto-special-offer`,`truck_public`,
        `truck_seller_name`,`truck_seller_price`,`truck_seller_date`,`truck_seller_invoicenum`,
        `truck_buyer_name`,`truck_buyer_price`,`truck_buyer_date`,`truck_buyer_invoicenum`,`truck_product_status`)
    values ('', 
          $saxonid, $makeid, $_REQUEST['function'], $_REQUEST['model'],  $_REQUEST['fuel'],  $_REQUEST['maxload'], $_REQUEST['maxheight'],  $_REQUEST['status'], 
          $typeid, $cost, $_REQUEST['price'],  $rent, $now, $reserve, $active, $offstart, $offend, $offprice,
          $image, $_REQUEST['pwheel'], $_REQUEST['swheel'], $_REQUEST['engine'], $_REQUEST['drivetrain'], $_REQUEST['hours'],  $_REQUEST['year'], $_REQUEST['serial'], $_REQUEST['weight'], $_REQUEST['extras'], 
          $_REQUEST['publicdesc'], $_REQUEST['internaldesc'], $loc[0], $loc[1],$_REQUEST['length'],$_REQUEST['width'],$_REQUEST['turning-circle'],$depot,$sdepot,$state,
          $_REQUEST['warranty'], $_REQUEST['arrival'], $resstart, $resend, $_REQUEST['ispart'], $ttemp, $_REQUEST['shortdesc'], $_REQUEST['forks'],$soffer,$_REQUEST['truck_public'],
          $_REQUEST['seller_name'], $_REQUEST['seller_price'], $_REQUEST['seller_date'], $_REQUEST['seller_invoicenum'],
          $_REQUEST['buyer_name'],  $_REQUEST['buyer_price'],  $_REQUEST['buyer_date'],  $_REQUEST['buyer_invoicenum'], $_REQUEST['truck_prodstat'])";       */

    $para = "
    	insert into `trucks`
			(
				`truck_id`,
				`truck_saxon-id`,
				`truck_make`,
				`truck_function`,
				`truck_model`,
				`truck_fuel`,
				`truck_max-load`,
				`truck_max-height`,
				`truck_status`,
				`truck_type`,
				`truck_cost`,
				`truck_reseller_price`,
				`truck_rent`,
				`truck_date`,
				`truck_reserved`,
				`truck_special-offer-active`,
				`truck_special-offer-start`,
				`truck_special-offer-end`,
				`truck_special-offer-price`,
				`truck_default-image`,
				`truck_powered-wheel`,
				`truck_steered-wheel`,
				`truck_engine`,
				`truck_drivetrain`,
				`truck_hours-used`,
				`truck_year`,
				`truck_serial`,
				`truck_weight`,
				`truck_extras`,
				`truck_desc`,
				`truck_internal-desc`,
				`truck_full-height`,
				`truck_cabin-height`,
				`truck_length`,
				`truck_width`,
				`truck_lifting-column-height`,
				`truck_depot`,
				`truck_sub-depot`,
				`truck_state`,
				`truck_warranty`,
				`truck_expected-arrival`,
				`truck_reserve-start`,
				`truck_reserve-end`,
				`truck_ispart`,
				`truck_temp`,
				`truck_short-comment`,
				`truck_forks`,
				`truck_auto-special-offer`,
				`truck_public`,
				`truck_seller_name`,
				`truck_seller_price`,
				`truck_seller_date`,
				`truck_seller_invoicenum`,
				`truck_buyer_name`,
				`truck_buyer_price`,
				`truck_buyer_date`,
				`truck_buyer_invoicenum`,
				`truck_product_status`,
				`truck_loc_x`,
				`truck_loc_y`
			) values (
				'',
				'".addslashes($saxonid)                      . "', 
				'".addslashes($makeid)                       . "',
				'".addslashes($_REQUEST['function'])         . "',
				'".addslashes($_REQUEST['model'])            . "',
				'".addslashes($_REQUEST['fuel'])             . "',
				'".addslashes($_REQUEST['maxload'])          . "',
				'".addslashes($_REQUEST['maxheight'])        . "',
				'".addslashes($_REQUEST['status'])           . "',
				'".addslashes($typeid)                       . "',
				'".addslashes($cost)                         . "',
				'".addslashes($_REQUEST['price'])            . "',
				'".addslashes($rent)                         . "',
				'".addslashes($now)                          . "',
				'".addslashes($reserve)                      . "',
				'".addslashes($active)                       . "',
				'".addslashes($offstart)                     . "',
				'".addslashes($offend)                       . "',
				'".addslashes($offprice)                     . "',
				'".addslashes($image)                        . "',
				'".addslashes($_REQUEST['pwheel'])           . "',
				'".addslashes($_REQUEST['swheel'])           . "',
				'".addslashes($_REQUEST['engine'])           . "',
				'".addslashes($_REQUEST['drivetrain'])       . "',
				'".addslashes($_REQUEST['hours'])            . "',
				'".addslashes($_REQUEST['year'])             . "',
				'".addslashes($_REQUEST['serial'])           . "',
				'".addslashes($_REQUEST['weight'])           . "',
				'".addslashes($_REQUEST['extras'])           . "',
				'".addslashes($_REQUEST['publicdesc'])       . "',
				'".addslashes($_REQUEST['internaldesc'])     . "',
				'".addslashes($loc[0])                       . "',
				'".addslashes($loc[1])                       . "',
				'".addslashes($_REQUEST['length'])           . "',
				'".addslashes($_REQUEST['width'])            . "',
				'".addslashes($_REQUEST['turning-circle'])   . "',
				'".addslashes($depot)                        . "',
				'".addslashes($sdepot)                       . "',
				'".addslashes($state)                        . "',
				'".addslashes($_REQUEST['warranty'])         . "',
				'".addslashes($_REQUEST['arrival'])          . "',
				'".addslashes($resstart)                     . "',
				'".addslashes($resend)                       . "',
				'".addslashes($_REQUEST['ispart'])           . "',
				'".addslashes($ttemp)                        . "',
				'".addslashes($_REQUEST['shortdesc'])        . "',
				'".addslashes($_REQUEST['forks'])            . "',
				'".addslashes($soffer)                       . "',
				'".addslashes($_REQUEST['truck_public'])     . "',
				'".addslashes($_REQUEST['seller_name'])      . "',
				'".addslashes($_REQUEST['seller_price'])     . "',
				'".addslashes($_REQUEST['seller_date'])      . "',
				'".addslashes($_REQUEST['seller_invoicenum']). "',
				'".addslashes($_REQUEST['buyer_name'])       . "',
				'".addslashes($_REQUEST['buyer_price'])      . "',
				'".addslashes($_REQUEST['buyer_date'])       . "',
				'".addslashes($_REQUEST['buyer_invoicenum']) . "',
				'".addslashes($_REQUEST['truck_prodstat'])   . "',
				'".addslashes($_REQUEST['truck_loc_x'])      . "',
				'".addslashes($_REQUEST['truck_loc_y'])      . "'
			)";

 			if (mysqli_query($link, $para)) { 
         /*echo 'A tétel >'.$saxonid.'< Saxon számon felrögzítve.';
         sleep(5);
         echo 'A tétel >'.$saxonid.'< Saxon számon felrögzítve.';
         sleep(5);
         exit();*/

        $para = "SELECT `truck_id`, `truck_saxon-id` FROM trucks WHERE `truck_saxon-id`='". $saxonid . "' LIMIT 1";
         $result = mysqli_query($link, $para);
         $data = mysqli_fetch_assoc($result);
         $truckid = $data["truck_id"];

         }
      else {
        echo "Error: " . $para . "<br>" . mysqli_error($link);
        exit();
      }


      // Tárolási hely log ********************
      
      $loctext = '';
      $old_depot = '0';
      $old_sdepot = '0'; 
      
      $stmt = "SELECT * from truck_location WHERE depot=".$loc[0]." AND subdepot=0";
      $result = mysqli_query($link, $stmt);
      $data = mysqli_fetch_assoc($result);
      $loctext2 = $data["value"];        
      
      $stmt = "SELECT * from truck_location WHERE depot=".$loc[0]." AND subdepot=".$loc[1];
      $result = mysqli_query($link, $stmt);
      $data = mysqli_fetch_assoc($result);
      $loctext2 .= ' '.$data["value"];  
      
      if (empty($loctext)){ $loctext = 'Üres'; } 
      if (empty($loctext2)){ $loctext2 = 'Üres'; } 
      
      $modetext = ' Mode: Felvitel (új targonca)';

      if ($old_depot!=$loc[0] || $old_sdepot!=$loc[1]){
          writelog('Saxon ID: '.$saxonid.' ['.$old_depot.'/'.$old_sdepot.']-'.$loctext.' ==> ['.$loc[0].'/'.$loc[1].']'.$loctext2.' '.$modetext);
      }


    redirect_in_site("?page=truckman_edit&lang=hun&truckid=".$truckid);
  
    /*if ($stmt->execute()) {
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['get_truck_by_temp']);

        $stmt->bind_params($uid);

        if ($stmt->execute()) {
            $res = $stmt->fetch_row();
            $res = $res['truck_id'];

            $_SESSION['basket'] = array($res);

            // add_offer_request("", $_REQUEST['offer_id']);

            // exit($_REQUEST['offer_id']);
            // copy_trucks_offer($_REQUEST['offer_id'], $res);

            return 1;
        }
    } else {
        return 11;
    } 
}     */

function writelog($p1)
{
  $logtext = date("Y-m-d H:i:s").' ==> '.$p1;
  file_put_contents("raktar-mozgatas-log.txt", $logtext."\r\n", FILE_APPEND);
}

?>