<?php
  include("common.php");
  
  $mysql = get_connection();
  $mysql->execute($sql['setutf']);
  $stmt = $mysql->execute("SELECT * FROM `allapot`");
  
  $result = $stmt->fetch_all();
  
  foreach($result as $data)
  {
   // $query = $sql['setutf']."";
  //  $query = "INSERT INTO truck_status_hun VALUES(".$data['ID'].",'".$data['nev']."')";
  // $query = "INSERT INTO truck_status_eng VALUES(".$data['ID'].",'".$data['nev_angol']."')";
    $query = "INSERT INTO truck_status_deu VALUES(".$data['ID'].",'".$data['nev_nemet']."')";
   // if($mysql->execute($query))
    {
      echo $data['ID']."<br />";
    }
  }
?>