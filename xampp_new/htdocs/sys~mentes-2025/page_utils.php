<?php
  function page_exists($page_name)
  {
    global $pages;
    if(array_key_exists($page_name,$pages) && 
       $pages[$page_name] > 0 &&
       file_exists("sys/pages/".$page_name.".php"))
    {
      return true;
    }
    return false;
  }
  
  function redirect_in_site($url)
  {
    global $config;
    
    $server_protocol = 'https://';
    $server_name = $config['server_name'];
    $script_path = $config['script_path'];

    header('Location:'.$server_protocol.$server_name.$script_path.$url);
  }
  
  function redirect($url)
  {
    header('Location:'.$url);    
  } 

  function generate_menu()
  {
    global $pages, $lang, $language;
    if(isset($pages))
    {
      $result = "";
      $count = 0;
      foreach($pages as $key => $value)
      {
        if($value == 1)
        {
          $class = $count == 0 ? "dMenuItemRed" : "dMenuItem";
          $result .= "<div class=\"$class\">\n";
          $result .= "<a href =\"?lang=$lang&amp;page=$key\">".$language['pages'][$key]."</a>\n";
          $result .= "</div>\n";
        }
        $count++;
      }
      return $result;
    }
    return false;
  }
  
function destroy_dir($dir, $path) 
{
  $dir = $path.$dir;
  $mydir = opendir($dir);
  
  while(false !== ($file = readdir($mydir))) 
  {
      if($file != "." && $file != "..") 
      {
          chmod($dir.$file, 0777);
          if(is_dir($dir.$file)) 
          {
              chdir('.');
              destroy($dir.$file.'/');
              rmdir($dir.$file);
          }
          else
              unlink($dir.$file);
      }
  }
  closedir($mydir);
  return true;
}
?>
