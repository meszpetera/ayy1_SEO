<?php 
  include_once("common.php");

  if (isset($_REQUEST['id']))
  {
    print(add_truck_to_basket($_REQUEST['id']));
  }
  else
  {
    print("-1");
  }

?>