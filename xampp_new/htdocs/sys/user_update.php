<?php
  include_once("common.php");
  if(loggedin())
  {
    $result = update_user();
    if($result != Update_Success)
    {
      redirect_in_site("?page=usercp&lang=$lang&error=$result");
    }    
    else
    {
      redirect_in_site("?page=usercp&lang=$lang");
    }
  }
?>