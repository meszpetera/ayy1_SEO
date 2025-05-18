<?php
  include_once('common.php');

  if (isauth())
  {
    if (isset($_REQUEST['truckid']) || isset($_REQUEST['offerid']))
    {
      $mysql = get_connection();  
      
      $stmt = $mysql->prepare($sql['offer_request:remove_truck_from_table']);
      $stmt->bind_params($_REQUEST['offerid'], $_REQUEST['truckid']);  
      
      if($stmt->execute())
      {
        $stmt = $mysql->prepare($sql['get_offer_trucks']);
        $stmt->bind_params($_REQUEST['offerid']);  
        
        if($stmt->execute())
        {
          $lol = $stmt->fetch_all();
          $lol = $lol[0]['offer_trucks'];
          
          $trucks = explode(';', $lol);
          $lol = '';
          $i = 0;
          for ($i = 0; $i < count($trucks); $i++)
          {
            if ($trucks[$i] != $_REQUEST['truckid'])
              $lol .= $trucks[$i] . ";";
          }
          $lol = trim($lol, ";");
          $stmt = $mysql->prepare($sql['offer_request:update']);
          $stmt->bind_params($_REQUEST['offerid'], $lol);  
          
          if($stmt->execute())
          {
            redirect_in_site("?page=offer_requests_edit&lang=hun&tmp=7&request=" . $_REQUEST['offerid']);
          }
          else
          {
            echo 'Hiba történt az eltávolítás során. A visszalépéshez kattintson <a href="https://'.($_SERVER['HTTP_HOST']).'/?page=offer_requests_edit&lang=hun&tmp=8&request=' . $_REQUEST['offerid'] . '">ide</a>';
          }
        }
      }      
    }
  }
?>