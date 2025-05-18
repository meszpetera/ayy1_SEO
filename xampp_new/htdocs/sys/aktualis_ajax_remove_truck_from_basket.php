<?php 
  include_once("common.php");
  
  if (isset($_REQUEST['id']))
    remove_truck_from_basket($_REQUEST['id']);
?>