<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $pagecount = $_SESSION['flyers']['pagecount'] -1;    
    $pageid = $_REQUEST['pageid'];
    
    foreach ($_SESSION['flyers'][$pageid]['trucks'] as $cell)
      $_SESSION['flyers']['trucks'][$cell['id']] = $cell['saxon-id'];
    
    unset($_SESSION['flyers'][$pageid]);
    
    for($i = $pageid; $i < $pagecount; $i++)
      $_SESSION['flyers'][$i] = $_SESSION['flyers'][$i + 1];
    
    $_SESSION['flyers']['pagecount'] = $pagecount;
    $_SESSION['flyer_changed'] = true;
    
    print('done');
  }
?>
