<?php

function lang_exists($language) {

    /*
      if (file_exists("/web/saxonrt/saxonrt.eu/www/sys/lang/" . $language) &&
      file_exists("/web/saxonrt/saxonrt.eu/www/sys/lang/" . $language . "/language.php")) {
     */
     
    if ( is_dir($_SERVER['DOCUMENT_ROOT']. "/sys/lang/" . $language.'/') 
        && file_exists($_SERVER['DOCUMENT_ROOT']."/sys/lang/" . $language . "/language.php")) {
        return true;
    }
    return false;
}

?>