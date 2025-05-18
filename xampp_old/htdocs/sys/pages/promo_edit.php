<?php
  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {  
	$template = new Template();    
    $variables = array(
                   "DATA" => get_all_promo_in_table());
    $template->assign_var_array($variables);
    
    $main_content = $template->compile("sys/lang/univ/promo_edit");  //WARNING: Language hardcoded, no other languages needed    
    include("sys/tpl/main.tpl");
  }
 ?>