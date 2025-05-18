<?php /* Készítő: H.Tibor */

$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__)).'/';
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);

/* Funkciók betőltése! */
if(is_dir(DOCUMENT_ROOT.'/saved_flyers/')) {
	if($_dh = opendir(DOCUMENT_ROOT.'/saved_flyers/')) {
		$functions = Array();
		while(($dir = readdir($_dh)) !== false) {
			if(filetype(DOCUMENT_ROOT.'/saved_flyers/'.$dir)=='dir'
				AND substr($dir,0,1)!='.') {
				if(is_file(DOCUMENT_ROOT.'/saved_flyers/'.$dir.'/email_hun.pdf')) {
					$url = 'http://www.saxonrt.hu/saved_flyers/'.$dir.'/email_hun.pdf';
					$name = $dir;
					echo'<option value="'.($url).'" '.((base64_decode($_REQUEST['cur'])==$url)?('SELECTED'):('')).'>'.($name).' [HUN]</option>';
				}
				if(is_file(DOCUMENT_ROOT.'/saved_flyers/'.$dir.'/email_eng.pdf')) {
					$url = 'http://www.saxonrt.hu/saved_flyers/'.$dir.'/email_eng.pdf';
					$name = $dir;
					echo'<option value="'.($url).'" '.((base64_decode($_REQUEST['cur'])==$url)?('SELECTED'):('')).'>'.($name).' [ENG]</option>';
				}
			}
		}
		closedir($_dh);
	}
}


?>