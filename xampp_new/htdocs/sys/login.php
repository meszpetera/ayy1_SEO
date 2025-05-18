<?php
  include_once("common.php");

  if(isset($_REQUEST['user_login']) && isset($_REQUEST['user_pass']) && !loggedin())
  {
    $status = login($_REQUEST['user_login'], $_REQUEST['user_pass']);
    //echo $status;
    if ($status == 1)
    {
        $redir = $_REQUEST['loginredir'] == "" ? "rolunk" : $_REQUEST['loginredir'];
       /// echo $redir;
        redirect_in_site("?page=".$redir."&lang=$lang");
    }
    else if($status == 0)
    {
      redirect_in_site("?page=login&lang=$lang&error=0");
    }
    else
    {
      redirect_in_site("?page=login&lang=$lang");
    }
  }
  else
  {
    redirect_in_site("?page=login&lang=$lang&error=3");
  }
?>