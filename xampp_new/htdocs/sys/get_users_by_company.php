<?php
  include_once("common.php");
  
  if(true && isset($_REQUEST['companyid']))
  {
    echo json_encode(get_users_by_company($_REQUEST['companyid']));
  }
?>