<?php
  include_once("common.php");
  
  if(ismain() && isset($_REQUEST['offerid']))
  {
    approve_offer_request($_REQUEST['offerid']);
    $offerid = $_REQUEST['offerid'];
    print(get_offerrequest_menu($_SESSION['users_id'], 4, $offerid) . "@" . 
              $language['offer_request:status'][1] . '<br /><br />' . $language['clerk'] . ':<br />' . $_SESSION['users_realname'] );
  }
  else
    echo "fasz";
?>