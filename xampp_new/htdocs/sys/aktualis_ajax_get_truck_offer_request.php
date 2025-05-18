<?php
  include_once("common.php");
  if(isset($_REQUEST['truckid']) && isset($_REQUEST['offerid']) && loggedin() & isauth())
  {
    $original = get_truck_details($_REQUEST['truckid']);
    $mod = get_truck_mod_info($_REQUEST['offerid'],$_REQUEST['truckid']);
	$images = get_offer_request_images($_REQUEST['truckid'],$_REQUEST['offerid']);
    
   /* $template = new Template();
    $variables = array (
                   "PRICE_ORIG" => $original[0]['truck_cost'],
                   "PRICE_MOD" => $mod['offer_truck_cost']
                 );
    
    $template->assign_var_array($variables);
    echo $template->compile();  //WARNING: Language hardcoded, no other languages needed*/
    include("tpl/offer_truck_edit.tpl");
  //  echo json_encode($result);
  }
?>