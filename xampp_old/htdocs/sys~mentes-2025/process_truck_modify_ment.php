<?php
  include_once("common.php");
  if(isauth())
  {
		
		
		$pdf = '/pdf/'.($_REQUEST['resaxonid']).'.pdf';
		if(is_file(DOCUMENT_ROOT.$pdf) AND ( $_POST['delpdf'] OR substr(strtolower($_FILES['pdf']['name']),-4)=='.pdf' )) {
			unlink(DOCUMENT_ROOT.$pdf);
		}
		if(substr(strtolower($_FILES['pdf']['name']),-4)=='.pdf') {
			move_uploaded_file($_FILES['pdf']['tmp_name'], DOCUMENT_ROOT.$pdf);
		}
		
          /************************************/

        	define('DB_HOST', '127.0.0.1');
        	define('DB_USER', 'saxonrt');
        	define('DB_PASSWORD', 'NwzV6Dc');
        	define('DB_DB', 'saxonrt');
        	$link	= @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
        	if( !$link ) {
        		print('Adatbazis csatlakozasi hiba.<br>');
        		exit();
        	} 
  
          // Régi raktár *****************
          
          $truckid = $_REQUEST['truckid'];
          $stmt = "SELECT `truck_id`,`truck_saxon-id`,`truck_depot`,`truck_sub-depot` FROM trucks WHERE `truck_id` = ".$truckid;
          $result = mysqli_query($link, $stmt);
          $data = mysqli_fetch_assoc($result);
          $old_depot = $data["truck_depot"];
          $old_sdepot = $data["truck_sub-depot"];
          $saxxid = $data["truck_saxon-id"];
          
          $stmt = "SELECT * from truck_location WHERE depot=".$old_depot." AND subdepot=0";
          $result = mysqli_query($link, $stmt);
          $data = mysqli_fetch_assoc($result);
          $loctext = $data["value"];        
          
          if ($old_sdepot!='0'){
             $stmt = "SELECT * from truck_location WHERE depot=".$old_depot." AND subdepot=".$old_sdepot;
             $result = mysqli_query($link, $stmt);
             $data = mysqli_fetch_assoc($result);
             $loctext .= ' '.$data["value"];
          }        
  
          /************************************/

        	/* "<option value=\"0\" " . ($pro == 0 ? "selected" : "") . ">Raktáron levõ</option>" .
        	"<option value=\"1\" " . ($pro == 1 ? "selected" : "") . ">Elõrendelt</option>" .
        	"<option value=\"2\" " . ($pro == 2 ? "selected" : "") . ">Bérbeadva</option>" .
        	"<option value=\"3\" " . ($pro == 3 ? "selected" : "") . ">Foglalt-Eladás alatt</option>" .
        	"<option value=\"4\" " . ($pro == 4 ? "selected" : "") . ">Eladva</option>" .
        	"<option value=\"5\" " . ($pro == 5 ? "selected" : "") . ">Bizományban</option>";*/

          $code = modify_truck();
          
          $mode =  $_REQUEST['mode'];
          // $mode_hun = 'Beszerzés';
          
          switch ($mode){
            case 'beszer':
                 $truck_product_status = '0';     // Raktáron levõ 
                 $depot = '1'; 
                 $subdepot = '0';                 // 1-0 --> Vecsés 1. 
                 $mode_hun = 'Beszerzés';
                 break;
            case 'eladas':
                 $truck_product_status = '4';     // Eladva 
                 $depot = '3'; 
                 $subdepot = '0';                 // 3-0--> Felújító, bonntó    0-0 --> Nincs ilyen kategória a truck_location táblában, de a tárolási hellyel valamit kezdeni kellett 
                 $mode_hun = 'Eladás';
                 break;
            case 'rakmoz':
                 $mode_hun = 'Raktári mozgatás';
                 // Az ág megmarad, de jelenleg a státusz és hely változatlan
                 break;
          }
          
          
          if ($mode=='beszer' || $mode=='eladas'){
              $stmt = "UPDATE trucks SET `truck_product_status`=".$truck_product_status.",
                                         `truck_depot`         =".$depot.",
                                         `truck_sub-depot`     =".$subdepot." WHERE `truck_id` = ".$truckid;
              $result = mysqli_query($link, $stmt);
          }

          // Új raktár ********************
          
          if ($mode=='beszer' || $mode=='eladas'){
             $location = $depot.'/'.$subdepot; }
          else {
             $location = $_REQUEST['location'];
          }
          $loc = explode('/', $location);
          
          $stmt = "SELECT * from truck_location WHERE depot=".$loc[0]." AND subdepot=0";
          $result = mysqli_query($link, $stmt);
          $data = mysqli_fetch_assoc($result);
          $loctext2 = $data["value"];        
          
          if ($loc[1]!=0){
            $stmt = "SELECT * from truck_location WHERE depot=".$loc[0]." AND subdepot=".$loc[1];
            $result = mysqli_query($link, $stmt);
            $data = mysqli_fetch_assoc($result);
            $loctext2 .= ' '.$data["value"];
          }  
          
          if (empty($loctext)){ $loctext = 'Üres'; } 
          if (empty($loctext2)){ $loctext2 = 'Üres'; } 
          
          if ($mode!=''){
             $modetext = ' Mode: '.$mode_hun;}
          else {
             $modetext = '';      
          }

          if ($old_depot!=$loc[0] || $old_sdepot!=$loc[1] || $mode!=''){
              writelog('Saxon ID: '.$saxxid.' ['.$old_depot.'/'.$old_sdepot.']-'.$loctext.' ==> ['.$loc[0].'/'.$loc[1].']-'.$loctext2.' '.$modetext);
          }

    
    if($code != 1)
    {
      if (isset($_REQUEST['retaddr']))
        redirect_in_site("?page=" . $_REQUEST['retaddr'] . "&pageid=" . $_REQUEST['pageid'] . "&lang=$lang");
      else
        redirect_in_site("?page=truckman_edit&lang=$lang&error=$code&truckid=" . $_REQUEST['truckid']);
    }
    else
    {
      if (isset($_REQUEST['retaddr']))
        redirect_in_site("?page=" . $_REQUEST['retaddr'] . "&pageid=" . $_REQUEST['pageid'] . "&lang=$lang");
      else
        redirect_in_site("?page=truckman_edit&lang=$lang&error=-1&truckid=" . $_REQUEST['truckid']);
    }
  }


function writelog($p1)
{
  $logtext = date("Y-m-d H:i:s").' ==> '.$p1;
  file_put_contents("raktar-mozgatas-log.txt", $logtext."\r\n", FILE_APPEND);
}



?>