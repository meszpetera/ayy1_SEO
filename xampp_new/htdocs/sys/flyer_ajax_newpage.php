<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $pagecount = $_SESSION['flyers']['pagecount'];
    
    $_SESSION['flyers'][$pagecount] = array();    
    $_SESSION['flyers'][$pagecount]['pagetype'] = $_REQUEST['pagetype'];
    $_SESSION['flyers'][$pagecount]['trucks'] = array();
    
    $_SESSION['flyers']['pagecount'] = $pagecount + 1;
    $_SESSION['flyer_changed'] = true;
    
    print('done');
  }
?>
