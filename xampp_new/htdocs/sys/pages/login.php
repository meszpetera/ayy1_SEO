 <?php
  $error = "";

  if(!loggedin())
  {
    if(isset($_REQUEST['error']))
    {
      $error = "<div class=\"dLoginError\">".$language['loginerrors'][$_REQUEST['error']]."</div>";
    }
    $template = new Template();
    $variables = array (
                 "error" => $error,
                 "login_redir" => isset($_REQUEST['redir'])? $_REQUEST['redir'] : "",
                 "NAME" => $language['login']['name'],
                 "PASS" => $language['login']['pass'],
                 "LOGIN" => $language['login']['submit']
               );
               
    $template->assign_var_array($variables);
    $main_content = $template->compile("sys/lang/" . $lang . "/login");
 
    include("sys/tpl/main.tpl");
  }
  else
  {
    redirect_in_site("?page=$prev_page&lang=$lang");
  }
 ?>