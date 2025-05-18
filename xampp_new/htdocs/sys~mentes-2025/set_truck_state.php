<?php
  include_once("common.php");
  
  if(isauth())
  {
    if(isset($_REQUEST['id']))
      truckman_set_sold($_REQUEST['id']);
	redirect_in_site("?page=truckman_edit&lang=hun");
  }
?>