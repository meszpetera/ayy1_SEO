<?php /* Készítő: H.Tibor */ if(!$_ENV["SiteStart"]) { header("HTTP/1.0 404 Not Found",true,404); exit(); }
$_ENV["DEBUG"] = false;

if(strstr(strtolower($_SERVER["HTTP_USER_AGENT"]),"googlebot") OR strstr(strtolower($_SERVER["HTTP_USER_AGENT"]),"bot")) {
	header("HTTP/1.0 404 Not Found",true,404); exit();
}

/* Error Reporting */
if($_ENV["DEBUG"]===true) {
	error_reporting(E_ALL);
	ini_set("error_reporting", E_ALL);
	ini_set("display_errors", 1);
} else {
	error_reporting(E_ALL & ~E_NOTICE ^ E_DEPRECATED & ~E_STRICT);
	ini_set("error_reporting", E_ALL & ~E_NOTICE ^ E_DEPRECATED & ~E_STRICT);
	if($_ENV["DEBUG"]==1) {
		ini_set("display_errors", 1);
	} else {
		ini_set("display_errors", 0);
	}
}

/* INI_Set Beállítások! */
setlocale(LC_ALL, "hu_HU.utf8");
date_default_timezone_set("Europe/Budapest");
ini_set("session.cookie_path", "/");
ob_start("ob_gzhandler");
session_start();

/* DocumentRoot */
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__));
define("DOCUMENT_ROOT",$_SERVER["DOCUMENT_ROOT"]);
define("WEB_ROOT",realpath(DOCUMENT_ROOT."/../"));


/* Funkciók betőltése! */
define("FUNCTIONS_ROOT",realpath(DOCUMENT_ROOT."/@functions"));
if(is_dir(FUNCTIONS_ROOT)) {
	if($dh = opendir(FUNCTIONS_ROOT)) {
		$functions = Array();
		while(($file = readdir($dh)) !== false) {
			if(filetype(realpath(FUNCTIONS_ROOT."/".$file)) == "file"
				AND substr($file,-4)  == ".php"
				AND substr($file,0,1) != "."
				AND substr($file,0,1) != "!"
				AND substr($file,0,1) != ";"
				AND substr($file,0,1) != "#"
			) {
				$functions[] = realpath(FUNCTIONS_ROOT."/".$file);
			}
		}
		closedir($dh);
		sort($functions);
		foreach($functions as $includ) { include_once($includ); }
	}
}

$ini_file = DOCUMENT_ROOT."/@config.ini";
if(is_file($ini_file)) {
	$ini_array = Ini_Struct::parse($ini_file);
	if($ini_array) {
		$_ENV = (
			(function_exists("array_replace_recursive"))
			?(array_replace_recursive($_ENV, $ini_array))
			:(array_merge_recursive($_ENV, $ini_array))
		);
	}
}

/* MySQLi Kapcsolat */
if($_ENV['CONF']['SQL']['HOST'] AND $_ENV['CONF']['SQL']['USER'] AND $_ENV['CONF']['SQL']['PASS'] AND $_ENV['CONF']['SQL']['DB']) {
	if($_ENV['MYSQLI'] = @mysqli_connect($_ENV['CONF']['SQL']['HOST'],$_ENV['CONF']['SQL']['USER'],$_ENV['CONF']['SQL']['PASS'])) {
		mysqli_select_db($_ENV['MYSQLI'],$_ENV['CONF']['SQL']['DB']);
		mysqli_query($_ENV['MYSQLI'],'SET NAMES utf8');
		mysqli_query($_ENV['MYSQLI'],'SET SQL_MODE="ALLOW_INVALID_DATES"');
	}
}

$_ENV["USER"] = Array();
$_ENV["JSON"] = Array();
$_ENV['JSON']['success'] = false;

?>