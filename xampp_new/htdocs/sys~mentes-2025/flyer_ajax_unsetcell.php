<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $pageid = $_REQUEST['pageid'];
    $cell = $_REQUEST['cellid'];
    
    $truckid = $_SESSION['flyers'][$pageid]['trucks'][$cell]['id'];    
    
    $_SESSION['flyers']['trucks'][$truckid] = $_SESSION['flyers'][$pageid]['trucks'][$cell]['saxon-id'];
    unset($_SESSION['flyers'][$pageid]['trucks'][$cell]);    
        
    print(list_flyer_trucks());
    $_SESSION['flyer_changed'] = true;
  }
?>
