<?php /* Készítő: H.Tibor */
$_ENV['DEBUG'] = 1;

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

$_ENV['func-max'] = 0;
$_ENV['func'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_functions_hun` ORDER BY `ID`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['func'][strtokey($sor['value'])] = $sor;
	if($_ENV['func-max'] < $sor['ID']) { $_ENV['func-max'] = $sor['ID']; }
}

$_ENV['status-max'] = 0;
$_ENV['status'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_status_hun` ORDER BY `ID`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['status'][strtokey($sor['value'])] = $sor;
	if($_ENV['status-max'] < $sor['ID']) { $_ENV['status-max'] = $sor['ID']; }
}

$_ENV['type-max'] = 0;
$_ENV['type'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_type_hun` ORDER BY `ID`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['type'][$sor['ispart']][strtokey($sor['value'])] = $sor;
	$_ENV['type'][strtokey($sor['value'])] = $sor;
	if($_ENV['type-max'] < $sor['ID']) { $_ENV['type-max'] = $sor['ID']; }
}

$_ENV['fuel-max'] = 0;
$_ENV['fuel'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_fuel_hun` ORDER BY `ID`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['fuel'][strtokey($sor['value'])] = $sor;
	if($_ENV['fuel-max'] < $sor['ID']) { $_ENV['fuel-max'] = $sor['ID']; }
}

$_ENV['make-max'] = 0;
$_ENV['make'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_make_hun` ORDER BY `ID`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['make'][strtokey($sor['value'])] = $sor;
	if($_ENV['make-max'] < $sor['ID']) { $_ENV['make-max'] = $sor['ID']; }
}

$_ENV['location'] = Array();
$con = mysqli_query($_ENV['MYSQLI'], 'SELECT * FROM `truck_location` ORDER BY `depot`, `subdepot`');
if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
while($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
	$_ENV['location'][strtokey($sor['value'])] = $sor;
}

$_ENV['ispart'] = Array(
	Array(
		"ID" => "0",
		"value" => "Villás targoncák",
		"chars" => "V,H"
	),
	Array(
		"ID" => "1",
		"value" => "Fődarabok",
		"chars" => "W,X,Y,T,E"
	),
	Array(
		"ID" => "2",
		"value" => "Építő-, ipari-, kommunális gépek",
		"chars" => "V,H"
	),
	Array(
		"ID" => "3",
		"value" => "Kézi emelők",
		"chars" => "R"
	),
	Array(
		"ID" => "4",
		"value" => "Adapterek",
		"chars" => "A"
	),
	Array(
		"ID" => "5",
		"value" => "Vontatók, pótkocsik, golfautók, spec. járművek",
		"chars" => "H,V"
	),
	Array(
		"ID" => "6",
		"value" => "Kiegészítők",
		"chars" => "K"
	),
	Array(
		"ID" => "7",
		"value" => "Sehová",
		"chars" => "V,H"
	),
	Array(
		"ID" => "8",
		"value" => "Emelő oszlopok",
		"chars" => "M"
	),
	Array(
		"ID" => "9",
		"value" => "Kerekek, gumik",
		"chars" => "G"
	),
	Array(
		"ID" => "10",
		"value" => "Akkumulátorok",
		"chars" => "B"
	),
	Array(
		"ID" => "11",
		"value" => "Valami",
		"chars" => "S"
	),
	Array(
		"ID" => "12",
		"value" => "Hajtóművek",
		"chars" => "T"
	),
	Array(
		"ID" => "13",
		"value" => "Hajtott hidak",
		"chars" => "Y"
	),
	Array(
		"ID" => "14",
		"value" => "Karosszéria elemek",
		"chars" => "W"
	),
	Array(
		"ID" => "15",
		"value" => "Hidraulika elemek",
		"chars" => "D"
	),
	Array(
		"ID" => "16",
		"value" => "Kormányzott hidak",
		"chars" => "X"
	),
	Array(
		"ID" => "17",
		"value" => "Motorok",
		"chars" => "E"
	),
	Array(
		"ID" => "18",
		"value" => "Töltők",
		"chars" => "C"
	),
	Array(
		"ID" => "19",
		"value" => "Villák",
		"chars" => "F"
	)
);

function find_ispart($char, $value, $ReturnAll=false) {
	$code = strtokey($value);
	foreach($_ENV['ispart'] as $ispart) {
		if(strtokey($ispart['value']) == $code) {
			if($ReturnAll) {
				return $ispart;
			} else {
				return $ispart['ID'];
			}
		}
	}
	foreach($_ENV['ispart'] as $ispart) {
		$chars = explode(',', $ispart['chars']);
		if(in_array($char, $chars)) {
			if($ReturnAll) {
				return $ispart;
			} else {
				return $ispart['ID'];
			}
		}
	}
}

function find_type($ispart,$value) {
	$code = strtokey($value);
	if(isSet($_ENV['type'][$ispart][$code]['ID'])) {
		return $_ENV['type'][$ispart][$code]['ID'];
	} else if(isSet($_ENV['type'][$code]['ID'])) {
		return $_ENV['type'][$code]['ID'];
	} else {
		if($_ENV['DEBUG']) print("Insert TYPE: {$value}\r\n");
		$_ENV['type-max']++;
		$ID = $_ENV['type-max'];
		if(!isSet($_ENV['type'][$code]['ID'])) {
			$_ENV['type'][$code]['ID'] = $ID;
			$_ENV['type'][$code]['value'] = $value;
			$_ENV['type'][$code]['ispart'] = $ispart;
		}
		$_ENV['type'][$ispart][$code]['ID'] = $ID;
		$_ENV['type'][$ispart][$code]['value'] = $value;
		$_ENV['type'][$ispart][$code]['ispart'] = $ispart;
		mysqli_query($_ENV['MYSQLI'], 'INSERT INTO `truck_type_hun` (`ID`, `value`, `ispart`) VALUES ( "'.(addslashes($ID)).'", "'.(addslashes($value)).'", "'.(addslashes($ispart)).'" )');
		if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
		return $ID;
	}
}

function find_make($value) {
	$code = strtokey($value);
	if(isSet($_ENV['make'][$code]['ID'])) {
		return $_ENV['make'][$code]['ID'];
	} else {
		if($_ENV['DEBUG']) print("Insert MAKE: {$value}\r\n");
		$_ENV['make-max']++;
		$ID = $_ENV['make-max'];
		$_ENV['make'][$code]['ID'] = $ID;
		$_ENV['make'][$code]['value'] = $value;
		mysqli_query($_ENV['MYSQLI'], 'INSERT INTO `truck_make_hun` (`ID`, `value`) VALUES ( "'.(addslashes($ID)).'", "'.(addslashes($value)).'" )');
		if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
		return $ID;
	}
}

function find_func($value) {
	$code = strtokey($value);
	if(isSet($_ENV['func'][$code]['ID'])) {
		return $_ENV['func'][$code]['ID'];
	} else {
		if($_ENV['DEBUG']) print("Insert FUNC: {$value}\r\n");
		$_ENV['func-max']++;
		$ID = $_ENV['func-max'];
		$_ENV['func'][$code]['ID'] = $ID;
		$_ENV['func'][$code]['value'] = $value;
		mysqli_query($_ENV['MYSQLI'], 'INSERT INTO `truck_functions_hun` (`ID`, `value`) VALUES ( "'.(addslashes($ID)).'", "'.(addslashes($value)).'" )');
		if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
		return $ID;
	}
}

function find_fuel($value) {
	$code = strtokey($value);
	if(isSet($_ENV['fuel'][$code]['ID'])) {
		return $_ENV['fuel'][$code]['ID'];
	} else {
		if($_ENV['DEBUG']) print("Insert FUEL: {$value}\r\n");
		$_ENV['fuel-max']++;
		$ID = $_ENV['fuel-max'];
		$_ENV['fuel'][$code]['ID'] = $ID;
		$_ENV['fuel'][$code]['value'] = $value;
		mysqli_query($_ENV['MYSQLI'], 'INSERT INTO `truck_fuel_hun` (`ID`, `value`) VALUES ( "'.(addslashes($ID)).'", "'.(addslashes($value)).'" )');
		if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
		return $ID;
	}
}

function find_status($value) {
	$code = strtokey($value);
	if(isSet($_ENV['status'][$code]['ID'])) {
		return $_ENV['status'][$code]['ID'];
	} else {
		if($_ENV['DEBUG']) print("Insert STATUS: {$value}\r\n");
		$_ENV['status-max']++;
		$ID = $_ENV['status-max'];
		$_ENV['status'][$code]['ID'] = $ID;
		$_ENV['status'][$code]['value'] = $value;
		mysqli_query($_ENV['MYSQLI'], 'INSERT INTO `truck_status_hun` (`ID`, `value`) VALUES ( "'.(addslashes($ID)).'", "'.(addslashes($value)).'" )');
		if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
		return $ID;
	}
}

$_ENV['terstatus'] = Array();
$_ENV['terstatus'][0] = 'Raktáron levő';
$_ENV['terstatus'][1] = 'Előrendelt';
$_ENV['terstatus'][2] = 'Bérbeadva';
$_ENV['terstatus'][3] = 'Foglalt-Eladás alatt';
$_ENV['terstatus'][4] = 'Eladva';
$_ENV['terstatus'][5] = 'Bizományban';

/* CSV */
/*
	[0] => Saxonszám
	[1] => Fajta
	[2] => Gyartmány
	[3] => Tipus
	[4] => Funkció
	[5] => Különleges tulajdonság
	[6] => Felszereltség
	[7] => Megjegyzés
	[8] => Üzemmód
	[9] => Teherbírás
	[10] => Emelő magasság
	[11] => Első kerék
	[12] => Hátsó kerék
	[13] => Motor
	[14] => Akkumulátor
	[15] => Villák
	[16] => Tárolás
	[17] => Tárolás
	[18] => Mező
	[19] => Mező
	[20] => Eladási ár
	[21] => Eladó neve
	[22] => Bizonylatszám
	[23] => Vételi ár
	[24] => Category
*/
/* SQL Keys */
$_ENV['KEYS'] = Array(
	0 => 'truck_saxon-id',
	1 => 'truck_type',
	2 => 'truck_make',
	3 => 'truck_model',
	4 => 'truck_function',
	5 => 'truck_short-comment',
	6 => 'truck_extras',
	7 => 'truck_desc',
	8 => 'truck_fuel',
	9 => 'truck_max-load',
	10 => 'truck_max-height',
	11 => 'truck_steered-wheel',
	12 => 'truck_powered-wheel',
	13 => 'truck_engine',
	// 14 => 'truck_public-desc',
	15 => 'truck_forks',
	16 => 'truck_depot',
	17 => 'truck_sub-depot',
	18 => 'truck_loc_x',
	19 => 'truck_loc_y',
	20 => 'truck_cost',
	21 => 'truck_seller_name',
	22 => 'truck_seller_invoicenum',
	23 => 'truck_seller_price',
	24 => 'truck_ispart'
);
$row = 0;
if(($handle = fopen(DOCUMENT_ROOT."import.csv", "r")) !== FALSE) {
	while(($data = fgetcsv($handle, 0, ";", '"', "\\" )) !== FALSE) {
		if($row) {
			$_ispart = find_ispart(substr($data[0],0,1),$data[24]);
			$_type = find_type($_ispart,$data[1]);
			$_make = find_make($data[2]);
			$_func = find_func($data[4]);
			$_fuel = find_fuel($data[8]);

			$_location_1 = $_ENV['location'][strtokey($data[16])]['depot'];
			$_location_2 = $_ENV['location'][strtokey($data[17])]['subdepot'];

			$data[1] = $_type;
			$data[2] = $_make;
			$data[4] = $_func;
			$data[8] = $_fuel;
			$data[16] = $_location_1;
			$data[17] = $_location_2;
			$data[24] = $_ispart;

			$con = mysqli_query($_ENV['MYSQLI'], '
				SELECT *
				FROM `trucks`
				WHERE `truck_saxon-id` = "'.(addslashes($data[0])).'"
				LIMIT 1
			');
			if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
			if($sor = mysqli_fetch_array($con, MYSQLI_ASSOC)) {
				$upd = '';
				for($n = 1; $n <= 24; $n++) {
					if($sor[$_ENV['KEYS'][$n]] != $data[$n]) { $upd .= "\t".$_ENV['KEYS'][$n].': '.$sor[$_ENV['KEYS'][$n]].' => '.$data[$n]."\r\n"; }
				}
				if($upd) {
					if($_ENV['DEBUG']) print("Update Truck: ".($data[0])." \r\n{$upd}\r\n");
				
					/* SQL Update */
					mysqli_query($_ENV['MYSQLI'], '
						UPDATE `trucks`
						SET
							`'.($_ENV['KEYS'][1]).'` = "'.(addslashes($data[1])).'",
							`'.($_ENV['KEYS'][2]).'` = "'.(addslashes($data[2])).'",
							`'.($_ENV['KEYS'][3]).'` = "'.(addslashes($data[3])).'",
							`'.($_ENV['KEYS'][4]).'` = "'.(addslashes($data[4])).'",
							`'.($_ENV['KEYS'][5]).'` = "'.(addslashes($data[5])).'",
							`'.($_ENV['KEYS'][6]).'` = "'.(addslashes($data[6])).'",
							`'.($_ENV['KEYS'][7]).'` = "'.(addslashes($data[7])).'",
							`'.($_ENV['KEYS'][8]).'` = "'.(addslashes($data[8])).'",
							`'.($_ENV['KEYS'][9]).'` = "'.(addslashes($data[9])).'",
							`'.($_ENV['KEYS'][10]).'` = "'.(addslashes($data[10])).'",
							`'.($_ENV['KEYS'][11]).'` = "'.(addslashes($data[11])).'",
							`'.($_ENV['KEYS'][12]).'` = "'.(addslashes($data[12])).'",
							`'.($_ENV['KEYS'][13]).'` = "'.(addslashes($data[13])).'",
							`'.($_ENV['KEYS'][15]).'` = "'.(addslashes($data[15])).'",
							`'.($_ENV['KEYS'][16]).'` = "'.(addslashes($data[16])).'",
							`'.($_ENV['KEYS'][17]).'` = "'.(addslashes($data[17])).'",
							`'.($_ENV['KEYS'][18]).'` = "'.(addslashes($data[18])).'",
							`'.($_ENV['KEYS'][19]).'` = "'.(addslashes($data[19])).'",
							`'.($_ENV['KEYS'][20]).'` = "'.(addslashes($data[20])).'",
							`'.($_ENV['KEYS'][21]).'` = "'.(addslashes($data[21])).'",
							`'.($_ENV['KEYS'][22]).'` = "'.(addslashes($data[22])).'",
							`'.($_ENV['KEYS'][23]).'` = "'.(addslashes($data[23])).'",
							`'.($_ENV['KEYS'][24]).'` = "'.(addslashes($data[24])).'"
						WHERE `truck_id` = "'.((int)$sor['truck_id']).'"
					');
					if($_ENV['DEBUG']) print(mysqli_error($_ENV['MYSQLI']));
					/**/
				}
			} else {
				$insert = '';
				for($n = 1; $n <= 24; $n++) {
					if($sor[$_ENV['KEYS'][$n]] != $data[$n]) { $insert .= "\t".$_ENV['KEYS'][$n].': '.$sor[$_ENV['KEYS'][$n]].' => '.$data[$n]."\r\n"; }
				}
				if($_ENV['DEBUG']) print("Insert Truck: ".($data[0])." \r\n{$insert}\r\n");
			}

		}
		// if($_ENV['DEBUG']) print_r($data);
		$row++;
	}
	fclose($handle);
}



?>