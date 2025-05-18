<?php
  include_once("common.php"); 

  if (loggedin() && (($_SESSION['users_type'] == 128) || ($_SESSION['users_type'] == 255)))
  {
    if (isset($_REQUEST['id']))
    {
      $offerid = $_REQUEST['id'];
      if (offerrequest_take($offerid, $_SESSION['users_id']))
        print(get_offerrequest_menu($_SESSION['users_id'], 1, $offerid) . "@" . 
              $language['offer_request:status'][1] . '<br /><br />' . $language['clerk'] . ':<br />' . $_SESSION['users_realname'] );
    }
  }
?> 