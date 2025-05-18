 <?php
  include_once("common.php"); 


  $basket = get_basket_summary();
  
  //$prev_reqs = get_offerrequests_byuser($_SESSION['users_id']);
  
  echo count($prev_reqs) . "@";
  include("tpl/offer_summary.tpl");  
  //print("lol");
  
  //onclick=\"iBox.showURL('sys/aktualis_ajax_truck_details.php?id=" . $result[$i]['truck_id'] . "', '', {width:700});return false;\"
?>