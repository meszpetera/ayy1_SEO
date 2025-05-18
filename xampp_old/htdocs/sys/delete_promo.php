<?php
  include_once('common.php');

  if (isauth())
  {
    if(isset($_REQUEST['id']))
    {
     // exit($_REQUEST['id']);
      del_promo_data($_REQUEST['id']);
      
      redirect_in_site("?page=promo_edit&lang=$lang");
    }
  }
?>