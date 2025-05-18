<?php /* Készítő: H.Tibor */ if(!$_ENV["SiteStart"]) { header("HTTP/1.0 404 Not Found",true,404); exit(); }

function is_mobile() { return ((preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])) ? (true) : (false)); }
function isMobile() { return is_mobile(); }
$_ENV['MOBIL'] = $_ENV['MOBILE'] = is_mobile();

function isSecure() { return ($_SERVER['SERVER_PORT'] == 443 || $_SERVER['REQUEST_SCHEME'] == 'https' || (isSet($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')); }
function is_ssl() { return isSecure(); }
function isSSL() { return isSecure(); }
$_ENV['HTTP'] = $_ENV['HTTPS'] = isSecure();

function fileWrite($file,$data='',$open=false) { $_data = ''; if(is_file($file) AND $open) { $_data = file_get_contents($file); } $fh = fopen($file, 'w'); fwrite($fh, ($_data.$data)); fclose($fh); }
function stripslashes_deep($s) { if(@get_magic_quotes_gpc()) { $s = ((is_array($s))?(array_map('stripslashes_deep', $s)):(stripslashes($s))); } return $s; }

function in_get($s) {
	$s = stripslashes_deep($s);
	if(!is_array($s)AND!is_object($s)) {
		$s = str_replace("→", "", $s);
		$s = str_replace("\\0", "", $s);
		$s = str_replace("\\Z", "", $s);
		$s = str_replace("\x00", "", $s);
		$s = str_replace("\x1a", "", $s);
		$s = str_replace(chr(0), "", $s);
		$s = str_replace(chr(26), "", $s);
	}
	return $s;
}

function in_text($s) {
	if(!is_array($s)AND!is_object($s)) {
		$s = in_get($s);
		$s = htmlspecialchars_decode($s);
		$s = str_replace(Array('Õ', 'õ', 'Û', 'û', "\t"), Array('Ő', 'ő', 'Ű', 'ű', ' '), $s);
		for($a=0;strstr($s,'  ');$a++) { $s = str_replace('  ',' ',$s); }
		if(substr($s,-1)==' ') { $s = substr($s,0,-1); }
		if(substr($s,0,1)==' ') { $s = substr($s,1); }
		$s = htmlspecialchars($s, ENT_IGNORE);
		$s = str_replace(Array('{','}'),Array('&#123;','&#125;'),$s);
		$s = str_replace(Array('"',"'"),Array('&#34;','&#39;'),$s);
	}
	return $s;
}

function in_html($s) {
	if(!is_array($s)AND!is_object($s)) {
		$s = in_get($s);
		$s = str_replace(Array('<pre','</pre>'), Array('<p','</p>'), $s);
		$s = str_replace(Array('<PRE','</PRE>'), Array('<p','</p>'), $s);
		$s = str_replace(Array('Õ', 'õ', 'Û', 'û'), Array('Ő', 'ő', 'Ű', 'ű'), $s);
		$s = htmlspecialchars($s, ENT_IGNORE);
		$s = htmlspecialchars_decode($s);
		$s = addslashes($s);
	}
	return $s;
}

function js_urldecode($s) {
	$s = str_replace('%u0170', 'Ű', $s);
	$s = str_replace('%u0171', 'ű', $s);
	$s = str_replace('%u0150', 'Ő', $s);
	$s = str_replace('%u0151', 'ő', $s);
	$s = in_text($s);
	return $s;
}

function RePost($tomb,$no=Array(),$_name='') { return ReInput($tomb,$no,$_name); }
function ReInput($tomb,$no=Array(),$_name='') { $out='';
	if(!is_array($tomb)) { $tomb = $_POST; }
	if(!is_array($no)) { $no = Array(); }
	foreach ($tomb as $name => $value) {
		if(((!(in_array($name,$no)) OR is_int($name)) AND ($value OR $value==0) ) OR is_array($value)) {
			if(!is_array($value)) {
				if(strlen($value)>0) {
					$out .= '<input type="hidden" name="'.(($_name)?($_name.'['.($name).']'):($name)).'" value="'.(in_text($value)).'" />';
				}
			} else {
				$out .= ReInput($value,$no,(($_name)?($_name.'['.($name).']'):($name)));
			}
		}
	}
	return $out;
}
function ReGet($tomb,$no=Array(),$_name='') { $out='';
	if(!is_array($tomb)) { $tomb = $_GET; }
	if(!is_array($no)) { $no = Array(); }
	foreach ($tomb as $name => $value) {
		if(((!(in_array($name,$no)) OR is_int($name)) AND ($value OR $value==0) ) OR is_array($value)) {
			if(!is_array($value)) {
				if(strlen($value)>0) {
					$out .= '&'.(($_name)?($_name.'['.($name).']'):($name)).'='.(in_text($value));
				}
			} else {
				$out .= ReGet($value,$no,(($_name)?($_name.'['.($name).']'):($name)));
			}
		}
	}
	return $out;
}

if(!function_exists('apache_request_headers')) {
	function apache_request_headers() {
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach($_SERVER as $key => $val) {
			if( preg_match($rx_http, $key) ) {
				$arh_key = preg_replace($rx_http, '', $key);
				$rx_matches = array();
				$rx_matches = explode('_', $arh_key);
				if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
					foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}
		return( $arh );
	}
}

function webCache($time) {
	if(substr($_SERVER['HTTP_HOST'], -3)=='.lh') { $time = -1; }
	$timestamp = time();
	$etag = md5($timestamp);
	$tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
	$headers = apache_request_headers();
	header("Last-Modified: ".$tsstring);
	header("ETag: \"{$etag}\"");
	header("Expires: Thu, 01-Jan-70 00:00:01 GMT");
	if(isset($headers['If-Modified-Since'])) {
		if(intval(time()) - intval(strtotime($headers['If-Modified-Since'])) < $time) {
			header("{$_SERVER["SERVER_PROTOCOL"]} 304 Not Modified",false,304);
			exit();
		}
	}
}

function formatSizeUnits($bytes) {
	if($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2, '.', ' ').' GB';
	} else if($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2, '.', ' ').' MB';
	} else if($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2, '.', ' ').' KB';
	} else if($bytes > 0) {
		$bytes = number_format($bytes, 0, '.', ' ').' B';
	} else {
		$bytes = '0 B';
	}
	return $bytes;
}

if(!function_exists('mb_substr')) {
	function mb_substr($a,$b=0,$c=null) {
		$a = iconv("UTF-8", "ISO-8859-2", $a);
		$a = substr($a,$b,$c);
		$a = iconv("ISO-8859-2", "UTF-8", $a);
		return $a;
	}
}
if(!function_exists('mb_strlen')) {
	function mb_strlen($a) {
		$a = iconv("UTF-8", "ISO-8859-2", $a);
		return strlen($a);
	}
}

/* Last CSS / JS Mod */
$_ENV['LastMod'] = date('Ymd',strtotime('-7 day')).'0000';
function getLastCssJavaMod() {
	foreach($_ENV['HEAD']['CSS'] AS $file) {
		if(is_file(DOCUMENT_ROOT.out_lang($file))) {
			$fTime = date('YmdHi',filectime(DOCUMENT_ROOT.out_lang($file)));
			if($fTime>$_ENV['LastMod']) {
				$_ENV['LastMod'] = $fTime;
			}
		}
	}
	foreach($_ENV['HEAD']['JAVA'] AS $file) {
		if(is_file(DOCUMENT_ROOT.out_lang($file))) {
			$fTime = date('YmdHi',filectime(DOCUMENT_ROOT.out_lang($file)));
			if($fTime>$_ENV['LastMod']) {
				$_ENV['LastMod'] = $fTime;
			}
		}
	}
	return $_ENV['LastMod'];
}

if(isSet($_REQUEST)) { $_REQUEST = in_get($_REQUEST); } else { $_REQUEST = Array(); }
if(isSet($_SESSION)) { $_SESSION = in_get($_SESSION); } else { $_SESSION = Array(); }
if(isSet($_COOKIE)) { $_COOKIE = in_get($_COOKIE); } else { $_COOKIE = Array(); }
if(isSet($_POST)) { $_POST = in_get($_POST); } else { $_POST = Array(); }
if(isSet($_GET)) { $_GET = in_get($_GET); } else { $_GET = Array(); }

if(!isSet($_SESSION['PHPSESSID']) AND !isSet($_COOKIE['PHPSESSID'])) { $_SESSION['PHPSESSID'] = $_REQUEST['PHPSESSID'] = session_id(); }
else if(isSet($_COOKIE['PHPSESSID'])) { $_SESSION['PHPSESSID'] = $_REQUEST['PHPSESSID'] = in_text($_COOKIE['PHPSESSID']); }

$_REQUEST = ((function_exists('array_replace_recursive'))?(array_replace_recursive($_REQUEST, $_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER)):($_REQUEST));
extract($_REQUEST, EXTR_PREFIX_INVALID, 'x');

if(!$_REQUEST['PHPSESSID']) { $_REQUEST['PHPSESSID'] = $_SESSION['PHPSESSID'] = $_COOKIE['PHPSESSID'] = $_SERVER['PHPSESSID'] = session_id(); }

if(isSet($_REQUEST['PHPSESSID'])) { setcookie('PHPSESSID', $_REQUEST['PHPSESSID'], time() + 3600, '/'); }
else if(isSet($_COOKIE['PHPSESSID'])) { $_REQUEST['PHPSESSID'] = $_COOKIE['PHPSESSID']; }

$_ENV['TIME'] = time();
?>