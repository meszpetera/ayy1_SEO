<?php
  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=rolunk&lang=$lang");
  }
  else
  {    
    $companies = get_companies();
    //$companies = $companies == 0 ? "" : $companies;
    $template = new Template();
    $variables = array (
                   "DATA" => $companies
                 );
    
    $template->assign_var_array($variables);
    
    if (isset($_REQUEST['inline']))
      $inline = 1;
      
    if (!isset($inline))
    {
      $main_content = $template->compile("sys/lang/hun/companies");  //WARNING: Language hardcoded, no other languages needed
      include("sys/tpl/main.tpl");
    }
    else
    {
      $inline_content = $template->compile("sys/lang/hun/companies_inline");  //WARNING: Language hardcoded, no other languages needed
    }
  }
?>