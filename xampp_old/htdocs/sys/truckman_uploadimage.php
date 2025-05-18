<?php
  include_once("common.php");
  $path = realpath("../") . "/";
  if (isauth())
  {  
    $files_uploaded = 0;
    $message = "";
    $lastimage = $_REQUEST['lastimage'];
    foreach ($_FILES as $key => $value)
    {
      $files_uploaded++;
      //$message = "done.";
      $src_filename = html_entity_decode(strtolower(htmlentities(basename($value['name']))));
      $path .= isset($_REQUEST['path']) ? $_REQUEST['path'] : "img/trucks/";
  
      if(!file_exists($path))
        mkdir($path, 0777);
      if (preg_match('/(?:\\.jpg)\\z/', $src_filename))
      { 
        $i = 1;
        $truckdetails = get_truck_details($_REQUEST['truckid']);
        
        $filename = $truckdetails[0]['truck_saxon-id'] . date('_y-m-d_His') . '.jpg';//$src_filename;
        //$filename=iconv("UTF-8", "ISO-8859-2", $filename);
        //exit($filename);
        while (file_exists($path . $filename)) 
        { 
          $filename = str_replace(".jpg", "_" . $i . ".jpg", $src_filename);
          $i++; 
        }
        $filename_max = str_replace(".jpg", "_max.jpg", $filename);
        //print('"' . $filename_max . '"');
        
        if (move_uploaded_file($value["tmp_name"], $path . $filename_max))
        {
          chmod($path . $filename_max, 0644);
					
					
          //create 320px wide thumbnail
          $q = 80;
					
          $width = 1000; 
          $im_s = imagecreatefromjpeg($path . $filename_max);
          $x_s = imagesx($im_s);
          $y_s = imagesy($im_s);
          $y1 = intval($y_s/($x_s/$width));
          $x1 = intval($x_s/($y_s/$y1));
          //$im_d = imagecreate($x1,$y1);
          //imagecopyresized($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
          $im_d = ImageCreateTrueColor($x1,$y1);
          imagecopyresampled($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
          imagejpeg($im_d, $path . $filename_max,$q);
					imagedestroy($im_s); imagedestroy($im_d);
					
					
          $width = 320; 
          $im_s = imagecreatefromjpeg($path . $filename_max);
          $x_s = imagesx($im_s);
          $y_s = imagesy($im_s);
          $y1 = intval($y_s/($x_s/$width));
          $x1 = intval($x_s/($y_s/$y1));
          //$im_d = imagecreate($x1,$y1);
          //imagecopyresized($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
          $im_d = ImageCreateTrueColor($x1,$y1);
          imagecopyresampled($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
          imagejpeg($im_d, $path . $filename,$q);
					imagedestroy($im_s); imagedestroy($im_d);
					
					
					
          //register the image for the truck
          if(isset($_REQUEST['offerid']))
          {
            $mysql = get_connection();
            $mysql->execute($sql['setutf']);
          
            $stmt = $mysql->prepare($sql['offer_addimage']);
            $stmt->bind_params($_REQUEST['truckid'], $filename, $_REQUEST['offerid']);
          }
          else
          {
            $mysql = get_connection();
            $mysql->execute($sql['setutf']);
            
            $c = get_image_count($_REQUEST['truckid']);
            print($c);
            
            if ($c > 0)
            {
              $stmt = $mysql->prepare($sql['truck_get-highest-image-id']);
              $stmt->bind_params($_REQUEST['truckid']);
              if ($stmt->execute())
              {
                $c = $stmt->fetch_all();
                $lastimage = $c[0]['lastimage'] + 1;
              }
            }
            else
              $lastimage = 0;
            
            $stmt = $mysql->prepare($sql['truck_addimage']);
            $stmt->bind_params($_REQUEST['truckid'], $lastimage, $filename);
          }
          if($stmt->execute()) 
          {
            $message = "A kép feltöltése sikerült.";
            $lastimage++;
          }
          else
            $message = "A kép feltöltése sikerült, de az adatbázisba rögzítés meghiúsult.";
        }
        else
          $message = "A kép feltöltése sikertelen.";
      }
    }
    
    print($message . "<br />");

    $url = "truckman_uploadimage.php?truckid=" . $_REQUEST['truckid'] . "&lastimage=" . $lastimage;
    if(isset($_REQUEST['offerid']))
    {
      $url .= "&offerid=".$_REQUEST['offerid']."&path=".$_REQUEST['path'];
    }
    print("<form action=\"$url\" enctype=\"multipart/form-data\" method=\"post\" accept-charset=\"UTF-8\">                 <input type=\"file\" size=\"45\" name=\"dpg_image\"/> <br />" .
          "  <div style=\"margin-top:20px; text-align:right; padding-right:12px; padding-bottom:12px;\">" .
          "    <input type=\"submit\" value=\"Feltöltés\" />" .
          "  </div>" .
          "</form>");
  }
?>