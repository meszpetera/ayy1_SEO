<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {  
    unset($_SESSION['flyers']);
    unset($_SESSION['flyer_id']);
    unset($_SESSION['flyer_title']);
    redirect_in_site("?page=flyer_editor&lang=hun");
  }
?>
