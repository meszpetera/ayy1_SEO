<?php
  include_once("common.php");

  if (isauth())
  {
    $_SESSION['offerwizard_company-id'] = $_REQUEST['id'];
    
    redirect_in_site("?page=new_offer&lang=hun&step=select_clerk");
  }
?>