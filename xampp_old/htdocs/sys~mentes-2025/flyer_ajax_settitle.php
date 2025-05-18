<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    print($_REQUEST['value']);
    $_SESSION['flyer_title'] = $_REQUEST['value'];
    $_SESSION['flyer_changed'] = true;
  }
?>
