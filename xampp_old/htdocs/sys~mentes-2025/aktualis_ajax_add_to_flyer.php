<?php
  include_once("common.php");
  
  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $mysql = get_connection();    
    $mysql->execute($sql['setutf']);
    
    foreach ($_SESSION['basket'] as $truckid)
    {
      $stmt  = $mysql->prepare($sql['truck_lesserdetails']);    
      $stmt->bind_params($lang, $truckid);    
      if($stmt->execute())
      {
        $truckdetails = $stmt->fetch_all();
        $_SESSION['flyers']['trucks'][$truckid] = $truckdetails[0]['truck_saxon-id'];
      }
    }
    $_SESSION['basket'] = array();
        
    print('done');
  }  
?>