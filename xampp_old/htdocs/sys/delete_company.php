<?php
  include_once("common.php");
  
  if(isauth())
  {
    delete_company($_REQUEST['cid']);
    
    if (isset($_REQUEST['inline']))
      redirect_in_site("?page=companies&lang=hun");
    else
      redirect_in_site("?page=companies&lang=hun");
  }
?>