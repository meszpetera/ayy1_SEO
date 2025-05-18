<?php
  function get_promo_data($site = "all")
  {
    global $sql;
    $mysql = get_connection();
    
    if($site == "all")
    {
      $stmt = $mysql->prepare($sql['get_promos']);
    }
    else
    {
      $stmt = $mysql->prepare($sql['get_promos_bysite']);
      $stmt->bind_params($site);
    }    
    
    $result = array();
    
    if($stmt->execute())
    {
      $result = $stmt->fetch_all();
      for($i = 0;$i<count($result);$i++)
      {
        $result[$i]['small_link'] = "img/promos/".$result[$i]['promo_thumb'];
        $result[$i]['big_link'] = "img/promos/".$result[$i]['promo_big'];
      }
    }
    return $result;
  }
  
  function get_next_promo($site = "all", $id = -1)
  {
    $promos = get_promo_data($site);
   // echo(count($promos));
    if($id > -1)
    {
      
      for($i = 0;$i<count($promos);$i++)
      {
        //echo($promos[$i]['promo_id']."<br />");
        if($promos[$i]['promo_id'] == $id && $i+1 < count($promos))
        {
          $new = $i;
          while($new == $i)
          {
            $new = rand(0,count($promos)-1);
          }
          return $promos[$new];
        }
      }
    }
    return $promos[0];
  }
  
   function get_every_promo_data()
  {
    global $sql;
    $mysql = get_connection();
    
    $stmt = $mysql->prepare($sql['get_promos_all']);
    
    $result = array();
    
    if($stmt->execute())
    {
      $result = $stmt->fetch_all();
      for($i = 0;$i<count($result);$i++)
      {
        $result[$i]['small_link'] = "img/promos/".$result[$i]['promo_thumb'];
        $result[$i]['big_link'] = "img/promos/".$result[$i]['promo_big'];
      }
    }
    return $result;
  }
  
  function get_promo($id)
  {
    global $sql;
    $mysql = get_connection();
    
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_promo_by_id']);
    $stmt->bind_params($id);
    
    if($stmt->execute())
    {
      $data = $stmt->fetch_row();
      
      return $data;
    }
  }
  
  function get_all_promo_in_table()
  {
    $data = get_every_promo_data();
	
	$result = "<table style=\"width:700px;\">";
	
	foreach($data as $promo)
	{
	  $result .= "<tr>";
	  
	  $result .= "<td>".$promo['promo_id']."</td>";
	  $result .= "<td><input name=\"check_".$promo['promo_id']."\" type=\"checkbox\" ".($promo['promo_enabled'] == 1 ? "checked" : "" )." value=\"true\" /></td>";
	  $result .= "<td><img src=\"".$promo['small_link']."\"></td>";
	  $result .= "<td><a href=\"sys/delete_promo.php?id=".$promo['promo_id']."\">Törlés</a></td>";
	  
	  $result .= "</tr>";
	}
	
	$result .= "</table>";
	
	return $result;
  }
  
  function update_promo_data($data)
  {
    global $sql;
    $mysql = get_connection();
		
	$toenable = array_keys($data, "true"); 
	
	$ids = "";
	
	for($i = 0;$i < count($toenable);$i++)
	{
		$ids .= ($i != 0 ? "," : "") .substr($toenable[$i],strpos($toenable[$i], "_")+1);
	}
	
	$stmt = $mysql->prepare($sql['set_promo_enabled']);
	$stmt->bind_params($ids);
	$stmt->execute();
	
	$stmt = $mysql->prepare($sql['set_promo_disabled']);
	$stmt->bind_params($ids);
	$stmt->execute();
  }
  
  function add_promo_data($filename, $filename_thumb)
  {
    global $sql;
    $mysql = get_connection();
    
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['insert_promo']);
    $stmt->bind_params($filename_thumb, $filename);
    
    return $stmt->execute();
  }
  
  function del_promo_data($id)
  {
    global $sql;
    $mysql = get_connection();
    
    $path = realpath("../") . "/";
    $data = get_promo($id);
    
    $myFile = $path.'img/promos/'.$data['promo_big'];
    $fh = fopen($myFile, 'w');
    fclose($fh);
    unlink($myFile);
    $myFile = $path.'img/promos/'.$data['promo_thumb'];
    $fh = fopen($myFile, 'w');
    fclose($fh);
    unlink($myFile);
    
    $stmt = $mysql->prepare($sql['delete_promo']);
    $stmt->bind_params($id);
    
    return $stmt->execute();
  }
?>