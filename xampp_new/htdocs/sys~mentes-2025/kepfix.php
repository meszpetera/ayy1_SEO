<?php
  if (false)
  {
    include_once("common.php");
    
    print("STARTING.<br />");
    
    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt  = $mysql->prepare("SELECT * FROM truck_images");
            
    if($stmt->execute())
    {
      $result = $stmt->fetch_all();
      $noskipping = false;
      foreach ($result as $record)
      {
       // if ($record['image_filename'] == "V-1481_1.jpg")
          //$noskipping = true;
        $img = $record['image_filename'];
        //$img = "A-0001_1.jpg";
        $img_max = str_replace(".jpg", "_max.jpg", $img);
          
//          print(((is_file('../img/trucks/' . $img_max) ? $img . " : " . "MAX : " : "")));
        //if ($noskipping)
        //{
          print($img . " : ");
          if (is_file('../img/trucks/' . $img_max))
          {
            
/*  */          $width = 320; 
            $q = 80; 
            $im_s = imagecreatefromjpeg('../img/trucks/' . $img_max);
            $x_s = imagesx($im_s);
            if ($x_s != 320) print($x_s . "<br />");
            $y_s = imagesy($im_s);
            $y1 = intval($y_s/($x_s/$width));
            $x1 = intval($x_s/($y_s/$y1));
            $im_d = ImageCreateTrueColor($x1,$y1);
           // imagecopyresampled($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
           // imagejpeg($im_d, '../img/trucks/' . $img, $q);
          }
          print("OK<br />");
        //}
       // else
      //    print("skipped<br />");
      }
    }
  }
  print("DONE.<br />");
?>