<?php /* Készítő: H.Tibor */ if(!$_ENV["SiteStart"]) { header("HTTP/1.0 404 Not Found",true,404); exit(); }

/* Pages betőltése! */
define("PAGE_ROOT",realpath(DOCUMENT_ROOT."/@pages"));

$_ENV['PAGES'] = Array();
if(is_dir(PAGE_ROOT)) {
	if($dh = opendir(PAGE_ROOT)) {
		$functions = Array();
		while(($file = readdir($dh)) !== false) {
			if(   substr($file,0,1) != "."
				AND substr($file,0,1) != "@"
				AND substr($file,0,1) != "!"
				AND substr($file,0,1) != ";"
				AND substr($file,0,1) != "#"
			) {
				if(filetype(realpath(PAGE_ROOT."/".$file)) == "file" AND substr($file,-4)  == ".php") {
					$_ENV['PAGES'][strtolower(substr($file,0,-4))] = substr($file,0,-4);
				} else {
					$_ENV['PAGES'][strtolower($file)] = $file;
				}
			}
		}
	}
}

$_ENV['PAGE'] = ((isSet($_ENV['PAGES'][$_ENV['REURL'][1]]))?($_ENV['PAGES'][$_ENV['REURL'][1]]):(false));
if(is_dir(PAGE_ROOT) AND $_ENV['PAGE'] AND $_ENV['PAGE']!='index') {
	ob_start();
			if(is_file(PAGE_ROOT.'/'.($_ENV['PAGE']).'.php')) {
			include(PAGE_ROOT.'/'.($_ENV['PAGE']).'.php');
		} else if(is_file(PAGE_ROOT.'/'.($_ENV['PAGE']).'/index.php')) {
			include(PAGE_ROOT.'/'.($_ENV['PAGE']).'/index.php');
		}
		$PrintData = ob_get_contents();
		if($PrintData) { $_ENV['JSON']['DATA'] = $PrintData; }
	ob_end_clean();
}


?>