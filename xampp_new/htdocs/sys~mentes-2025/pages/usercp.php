<?php
  if(loggedin())
  {
    $list = print_offer_set(get_offer_request_list_customer($_SESSION['users_id']));
  
    $template = new Template();
    $variables = array (
                 "FULLNAME" => $_SESSION['users_realname'],
                 "EMAIL" => $_SESSION['users_email'],
                 "PHONE" => $_SESSION['users_phone'],
                 "FAX" => $_SESSION['users_fax'],
                 "LOGOUT" => $language['logout'],
                 "TITLE" => $language['usercp']['title'],
                 "PERSONAL" => $language['usercp']['personal'],
                 "TRACE" => $language['usercp']['trace'],
                 "REQUESTLIST" => $list,
                 "ERROR" => $language["usercp"]["error"][$_REQUEST['error']]
               );
               
    $template->assign_var_array($variables);
    $main_content = $template->compile("sys/lang/" . $lang . "/usercp");
    
    include("sys/tpl/main.tpl");
  }
  else
  {
    redirect_in_site("?page=login&lang=$lang");
  }
?>