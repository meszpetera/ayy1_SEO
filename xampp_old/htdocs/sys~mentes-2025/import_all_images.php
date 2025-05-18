<?php
  print("WARNING: clean tha database first!");
  
  if (false)
  {
    include_once("common.php");

      print("dir opening....<br />");
    $dhandle = opendir('../img/trucks');
    if ($dhandle) 
    {
      print("dir open.<br />");
      while (($fname = readdir($dhandle)) !== false) 
      {
        if (($fname != '.') && ($fname != '..')) 
        {
        
          print("processing a file<br />");
          $images = array(0 => $fname);
          $i = 0;
          do
          {
            $i++;
            $filename = str_replace(".jpg", "_$i.jpg", $fname);
            $images[$i] = $filename;
          }
          while (is_file('../img/trucks/' . $filename) && ($filename != $fname));
          
          if ($i > 1)
          {
            $mysql = get_connection();
            $mysql->execute($sql['setutf']);
            $stmt  = $mysql->prepare("SELECT * FROM truck_images WHERE `image_filename` = '" . $images[0] . "'");
            
            if($stmt->execute())
            {
              $result = $stmt->fetch_all();
              print($images[0] . ' belongs to truck #' . $result[0]['image_truck-id'] . ' as image #' . $result[0]['image_id'] . '<br />');
            }
            
            for ($j = 1; $j < $i; $j++)
            {
              $stmt  = $mysql->prepare("INSERT INTO `truck_images` (`image_unique-id`, `image_truck-id`, `image_id`, `image_filename`) VALUES ('', '" . $result[0]['image_truck-id'] . "', '" . $j . "', '" . $images[$j] . "')");
              
              if($stmt->execute())
              {
                print("&nbsp;&nbsp;&nbsp;" . $images[$j] . " inserted as #$j<br />");
              }
            }
          }
        }
      }
      closedir($dhandle);
    }
  }
  print("&nbsp;&nbsp;&nbsp;DONE.<br />");

?>