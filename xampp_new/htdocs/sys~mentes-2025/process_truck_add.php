<?php
  include_once("common.php");
  if(isauth())
  {
    $code = add_truck();
    if($code != 1)
    {
      redirect_in_site("?page=truckman_new&offer_request=".$_REQUEST['offer_id']."&lang=$lang&error=$code");
    }
    else
    {
      redirect_in_site("?page=offer_requests_edit&lang=$lang&tmp=9&request=".$_REQUEST['offer_id']);
    }
  }
?>