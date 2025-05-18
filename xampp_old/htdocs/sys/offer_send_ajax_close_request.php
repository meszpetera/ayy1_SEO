<?php
  include_once("common.php");
  
  if(isauth() && isset($_REQUEST['offerid']))
  {
    return close_offer_request($_REQUEST['offerid']);
  }
?>