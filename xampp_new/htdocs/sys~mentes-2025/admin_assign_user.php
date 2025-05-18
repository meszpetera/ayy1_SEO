<?php
  include_once("common.php");
  if(isauth())
  {
    assign_user_to_company($_REQUEST['userid'], $_REQUEST['companyid']);
  }
?>