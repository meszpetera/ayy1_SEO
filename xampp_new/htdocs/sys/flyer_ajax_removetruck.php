<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $truckid = $_REQUEST['truckid'] . "";
    
    unset($_SESSION['flyers']['trucks'][$truckid]);
        
    print(list_flyer_trucks());
    $_SESSION['flyer_changed'] = true;
  }
?>
