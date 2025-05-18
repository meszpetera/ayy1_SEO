<?php
  include("common.php");
  
  if(loggedin() && isauth())
  {
    $res = update_copied_truck_info();
    if($res == 1)
      echo $language['admin:success'];
    else
      echo $language['admin:failed'];
  }
?>