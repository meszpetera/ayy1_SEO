<?php
//this sould not be executed again
/*
  include_once("common.php");

  $mysql = get_connection();
  $mysql->execute($sql['setutf']);
  $stmt  = $mysql->prepare("SELECT * FROM trucks");
  
  if($stmt->execute())
  {
    $result = $stmt->fetch_all();
    for ($i = 0; $i < count($result); $i++)
    {
      $a = str_replace('-0', '-', $result[$i]['truck_saxon-id']);
      print($a . '      ' . $result[$i]['truck_saxon-id'] . '<br />');
      if ($mysql->execute("UPDATE trucks SET `truck_saxon-id` = '" . $a . "' WHERE `truck_id` = '" . $result[$i]['truck_id'] . "'"))
        print("&nbsp;&nbsp;&nbsp;good<br />");
      else
        print("&nbsp;&nbsp;&nbsp;bad<br />");
    }
  }
  */
?>