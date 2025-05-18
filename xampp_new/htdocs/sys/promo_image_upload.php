<?php
  include_once("common.php");
  $path = realpath("../") . "/";
  if (isauth())
  {  
    $files_uploaded = 0;
    $message = "";
    foreach ($_FILES as $key => $value)
    {
      $files_uploaded++;

      $src_filename = html_entity_decode(strtolower(htmlentities(basename($value['name']))));
      $path .= "img/promos/";
      if (preg_match('/(?:\\.jpg)\\z/', $src_filename))
      { 
        $i = 1;
        
        $filename = "original_".$src_filename;
        //$filename=iconv("UTF-8", "ISO-8859-2", $filename);

        while (file_exists($path . $filename)) 
        { 
          $filename = str_replace(".jpg", "_" . $i . ".jpg", $src_filename);
          $i++; 
        }
        $filename_thumb = str_replace("original", "thumbnail", $filename);
        //print('"' . $path . $filename . '"');
        
        if (move_uploaded_file($value["tmp_name"], $path . $filename))
        {
          //create 320px wide thumbnail
          $width = 140; 
          $q = 80; 
          $im_s = imagecreatefromjpeg($path . $filename);
          $x_s = imagesx($im_s);
          $y_s = imagesy($im_s);
          $y1 = intval($y_s/($x_s/$width));
          $x1 = intval($x_s/($y_s/$y1));
          //$im_d = imagecreate($x1,$y1);
          //imagecopyresized($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
          $im_d = ImageCreateTrueColor($x1,$y1);
          imagecopyresampled($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
          imagejpeg($im_d, $path . $filename_thumb,$q);
          chmod($path . $filename,0644);
          chmod($path . $filename_thumb,0644);
          //register the image for the truck
          if(add_promo_data($filename,$filename_thumb))
          {
            $message = "A kép feltöltése sikerült.";
          }
          else
            $message = "A kép feltöltése sikerült, de az adatbázisba rögzítés meghiúsult.";
        }
        else
        {
          $message = "A kép feltöltése sikertelen.";
        }
      }
    }
    
    print($message . "<br />");

    $url = "promo_image_upload.php";

    print("<form action=\"$url\" enctype=\"multipart/form-data\" method=\"post\" accept-charset=\"UTF-8\">                 <input type=\"file\" size=\"45\" name=\"dpg_image\"/> <br />" .
          "  <div style=\"margin-top:20px; text-align:right; padding-right:12px; padding-bottom:12px;\">" .
          "    <input type=\"submit\" value=\"Feltöltés\" />" .
          "  </div>" .
          "</form>");
  }
?>