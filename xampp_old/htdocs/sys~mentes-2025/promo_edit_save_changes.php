<?php
  include_once("common.php");
  
  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {
    if(count($_POST) > 0 && $_POST['promo_form'] == '1')
	{
      update_promo_data($_POST);
	}
	
	redirect_in_site("?page=promo_edit&lang=$lang");
  }
?>