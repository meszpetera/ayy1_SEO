<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $pageid = $_REQUEST['pageid'];
    $cell = $_REQUEST['cellid'];
    $truckid = $_REQUEST['truckid'];
    
    $truck = get_truck_details($truckid);
    
    $_SESSION['flyers'][$pageid]['trucks'][$cell] = array('id' => $truckid, 'saxon-id' => $truck[0]['truck_saxon-id']);
    
    unset($_SESSION['flyers']['trucks'][$truckid]);
    
    
    print(get_flyer_cell($_SESSION['flyers'][$pageid]['trucks'][$cell], $cell));
    $_SESSION['flyer_changed'] = true;
  }
?>
