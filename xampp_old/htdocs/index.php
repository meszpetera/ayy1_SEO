<?php

  include_once("sys/common.php");
  
  if(isset($_SESSION['prev_page']))
  {
    $prev_page = $_SESSION['prev_page'];
  }
  else
    $prev_page = $default_page;
  
  if(isset($_REQUEST['page']) && page_exists($_REQUEST['page']))
  {
    $active_page = $_REQUEST['page'];
  }
  else if(page_exists($default_page))
  {
    $active_page = $default_page;
  }
  else
  {
    $main_content = "No data....";
    $active_page = "NULL";
    include("sys/tpl/main.tpl");
  }
  if(!in_array($active_page, $restricted))
  {
    $_SESSION['prev_page'] = $active_page;
  }
  include("sys/pages/".$active_page.".php");

  stream_context_set_default([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
        "allow_self_signed" => true
    ]
  ]);
?>