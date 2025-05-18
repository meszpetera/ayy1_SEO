<?php
  include_once("common.php");
  
  if(isauth())
  {
    delete_request($_REQUEST['offerid']);
    
    redirect_in_site("?page=offer_requests&lang=hun");
  }
?>