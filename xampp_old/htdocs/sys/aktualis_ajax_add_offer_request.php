<?php
  include_once("common.php");
  
  $addto = -1;
  
  if(isset($_REQUEST['add']))
  {
    $addto = $_REQUEST['add'];
  }
  $user = isset($_REQUEST['userid']) ? $_REQUEST['userid'] : $_SESSION['users_id'];
  //exit($_REQUEST['comment']);
  $res = add_offer_request($user, $addto);
  if ($res && !isauth())
    print($language['aktualis_offersummary:SUCCESS']);
  else if(!$res)
    print($language['aktualis_offersummary:FAIL']);
  else if($res && isauth())
  {
    echo "!redir!";
  }
    //echo $addto;
  
?>