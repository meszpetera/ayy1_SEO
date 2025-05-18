<?php
  include_once("common.php");

  if (isauth())
  {
    $mysql = get_connection();  
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare('SELECT LAST_INSERT_ID()');
    add_offer_request($_REQUEST['uid']);
    $stmt->execute();
    $id = $stmt->fetch_all();
    $id = $id[0]['LAST_INSERT_ID()'];
    offerrequest_take($id, $_SESSION['users_id']);
    print($id);
  }
?>