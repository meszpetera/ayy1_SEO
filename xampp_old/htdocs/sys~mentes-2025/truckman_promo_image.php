<?php
  include_once("common.php");
  
  if (isauth())
  {
    if (isset($_REQUEST['truckid']) && isset($_REQUEST['imagename']))
    {
      $mysql = get_connection();
      $mysql->execute($sql['setutf']);
			
			$src_filename = html_entity_decode(strtolower(htmlentities(basename(str_replace('_max.jpg','.jpg',$_REQUEST['imagename'])))));
			$path .= "../img/promos/";
			$filename = "original_".$src_filename;
			$i = 1;
			while(file_exists($path . $filename)) 
			{ 
				$filename = str_replace(".jpg", "_" . $i . ".jpg", $src_filename);
				$i++; 
			}
			$filename_thumb = str_replace("original", "thumbnail", $filename);
			if (copy('../img/trucks/'.$_REQUEST['imagename'], $path . $filename))
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
    }

    redirect_in_site("?page=promo_edit&lang=hun&truckid=" . $_REQUEST['truckid']);
  }
?>