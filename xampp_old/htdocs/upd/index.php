<?php /* Készítő: H.Tibor */
$_ENV['DEBUG'] = false;

if($_ENV['DEBUG']===true) {
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set("display_errors", 1);
} else {
	error_reporting(E_ALL & ~E_NOTICE ^ E_DEPRECATED & ~E_STRICT);
	ini_set('error_reporting', E_ALL & ~E_NOTICE ^ E_DEPRECATED & ~E_STRICT);
	if($_ENV['DEBUG']==1) {
		ini_set("display_errors", 1);
	} else {
		ini_set("display_errors", 0);
	}
}

/* INI_Set Beállítások! */
setlocale(LC_ALL, 'hu_HU.utf8');
setlocale(LC_NUMERIC, 'en_US.UTF-8'); /* Átkozot . -miat! */
date_default_timezone_set('Europe/Budapest');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_path', '/');
ob_start('ob_gzhandler');

/* DocumentRoot */
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__)).'/';
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);

function remove_accent($str) {
	$a=Array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','Ļ','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','Ż','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǎ','ǎ','Ǐ','ǐ','Ǒ','ǒ','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ǻ','ǻ','Ǽ','ǽ','Ǿ','ǿ');
	$b=Array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
	return str_replace($a,$b,$str);
}

function strtokey($str) {
	$str=str_replace(Array(' ',"\r","\n","\t"),'',$str);
	$str=str_replace(Array('/','"',"'",'&amp;','&quot;','&','\\'),'-',$str);
	$str=str_replace(Array('%20',' '),'-',$str);
	for($a=0;(strstr($str,'  ') AND $a<100);$a++){$str=str_replace('  ',' ',$str);}
	for($a=0;(strstr($str,'__') AND $a<100);$a++){$str=str_replace('__','_',$str);}
	for($a=0;(strstr($str,'--') AND $a<100);$a++){$str=str_replace('--','-',$str);}
	for($a=0;(strstr($str,'++') AND $a<100);$a++){$str=str_replace('++','+',$str);}
	if(substr($str,-1)==' '){$s=substr($str,0,-1);}
	if(substr($str,0,1)==' '){$s=substr($str,1);}
	if(substr($str,-1)=='-'){$s=substr($str,0,-1);}
	if(substr($str,0,1)=='-'){$s=substr($str,1);}
	if(substr($str,-1)=='_'){$s=substr($str,0,-1);}
	if(substr($str,0,1)=='_'){$s=substr($str,1);}
	$str=remove_accent($str);
	return $str;
}

/* MySQLi Kapcsolat */
$_ENV['MYSQLI'] = @mysqli_connect('localhost','saxonrt','NwzV6Dc');
mysqli_select_db($_ENV['MYSQLI'],'saxonrt');
mysqli_query($_ENV['MYSQLI'],'SET NAMES utf8');
mysqli_query($_ENV['MYSQLI'],'SET SQL_MODE="ALLOW_INVALID_DATES"');

$_ENV['location'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_location` WHERE `code`!="" ORDER BY `depot`, `subdepot`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['location'][strtokey($sor['code'])] = $sor;
}

$_ENV['location'][strtokey('COMING SOON')] = Array('depot'=>10, 'subdepot'=>0);
$_ENV['location'][strtokey('ÉRTÉKEN')] = Array('depot'=>7, 'subdepot'=>0);
$_ENV['location'][strtokey('SOLD 2020')] = Array('depot'=>3, 'subdepot'=>0);
$_ENV['location'][strtokey('SOLD')] = Array('depot'=>3, 'subdepot'=>0);

if($_ENV['DEBUG']) print_r($_ENV['location']);

function find_status($n) {
	$n = strtoupper($n);
	if($n == 'V1' OR $n == 'V2') { return 0; }
	if(substr($n, 0, 4) == 'SOLD') { return 4; }
	if(substr($n, 0, 6) == 'COMING') { return 1; }
	return 0;
}


/* TÖRLÉS;Saxonszám;Gyartmány;Tipus;Telephely;Oldal;Tárolás;Sorszám;Hely;Tatozék M;Tartozék A; */
if(($handle = fopen(DOCUMENT_ROOT."import.csv", "r")) !== FALSE) {
	while(($data = fgetcsv($handle, 0, ";", '"', "\\" )) !== FALSE) {
		$SaxonID   = $data[1];
//		$Gyartmany = find_make($data[2]);
//		$Tipus     = find_func($data[3]);
		$loc       = $_ENV['location'][strtokey($data[4].' '.$data[5].' '.$data[6])];
		$loc_1     = $loc['depot'];
		$loc_2     = $loc['subdepot'];
		$loc_x     = $data[7];
		$loc_y     = $data[8];
		$status    = find_status($data[4]);

		$upd = '
			UPDATE `trucks`
			SET
			`truck_depot` = "'.(addslashes($loc_1)).'",
			`truck_sub-depot` = "'.(addslashes($loc_2)).'",
			`truck_loc_x` = "'.(addslashes($loc_x)).'",
			`truck_loc_y` = "'.(addslashes($loc_y)).'",
			`truck_product_status` = "'.(addslashes($status)).'"
			WHERE `truck_saxon-id` = "'.(addslashes($SaxonID)).'";
		';
		if($loc_1) {
			if($_ENV['DEBUG']) print("Update Truck: ".($data[1])." \r\n{$upd}\r\n");
			mysqli_query($_ENV['MYSQLI'], $upd);
			if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
		}
	}
	fclose($handle);
}


?>