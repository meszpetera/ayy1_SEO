<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {  
    unset($_SESSION['flyer_id']);
    unset($_SESSION['flyer_title']);
    
    $_SESSION['flyers'] = array();
    $_SESSION['flyers']['pagecount'] = 0;
    $_SESSION['flyers']['trucks'] = array(1 => 'H-0151', 2 => 'S-0018');
    $_SESSION['flyer_changed'] = true;
    redirect_in_site("?page=flyer_editor&lang=hun");
  }
?>
