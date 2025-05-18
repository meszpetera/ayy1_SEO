<?php
  function get_connection()
  {
    global $db,$language;
//    global $mysqlconnection;
//    if ($mysqlconnection) return $mysqlconnection;
    Stat::increment('get_connection');
    $mysqlconnection = new mysql($db['host'], $db['password'], $db['user'], $db['dbname']);
    
    if(mysql_errno()) 
    {
      printf($language['connect_error'], mysql_error());
      exit();
    }
    
    return $mysqlconnection;
  }
