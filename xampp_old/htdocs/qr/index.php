<?php /* QR kód generátor */

	function in_get($s) {
		if(!is_array($s)AND!is_object($s)) {
			$s = str_replace('\\\\', '\\', $s);
			$s = str_replace('\"', '"', $s);
			$s = str_replace("\'", "'", $s);
			$s = str_replace("→", "", $s);
			$s = str_replace(chr(0), "", $s);
			$s = str_replace(chr(26), "", $s);
		}
		return $s;
	}

	function in_qr($s) {
		if(!is_array($s)AND!is_object($s)) {
			$s = in_get($s);
		}
		return $s;
	}

	if($_GET['text']){ $_data = $_GET['text']; } else { $_data = 'Ahoj :-)'; }
	if($_GET['URL']){ $_data = ((substr($_GET['URL'],0,4)=='http')?($_GET['URL']):('http://'.$_GET['URL'])); } else { $_data = 'http://'.($_SERVER['HTTP_HOST']).'/'; }
	if(is_numeric($_GET['size']) AND $_GET['size']>2 AND $_GET['size']<=20){ $size = $_GET['size']; } else { $size = 10; }
	if($_GET['q']=='L' OR $_GET['q']=='M' OR $_GET['q']=='Q' OR $_GET['q']=='H'){ $quality = $_GET['q']; } else { $quality = 'M'; }

	/* Hívás */
	if($_GET['TEL']) { $_data = "TEL:".in_qr($_GET['TEL']); }

	/* SMS küldés */
	if(is_array($_GET['SMSTO'])) { $_data = "SMSTO:".in_qr($_GET['SMSTO']['PHONE']).":".in_qr($_GET['SMSTO']['TEXT']); }

	/* Könyvjelző */
	if(is_array($_GET['MEBKM'])) { $_data = "MEBKM:TITLE:".in_qr($_GET['MEBKM']['TITLE']).";URL:".in_qr($_GET['MEBKM']['URL']).";;"; }

	/* Névjegy */
	if(is_array($_GET['MECARD'])) { $_data = "MECARD:N:".in_qr($_GET['MECARD']['N']).";ADR:".in_qr($_GET['MECARD']['ADR']).";TEL:".in_qr($_GET['MECARD']['TEL']).";EMAIL:".in_qr($_GET['MECARD']['EMAIL']).";;"; }

	/* Email küldés */
	if(is_array($_GET['EMAIL'])) { $_data = "MATMSG:TO:".in_qr($_GET['EMAIL']['TO']).";SUB:".in_qr($_GET['EMAIL']['SUB']).";BODY:".in_qr($_GET['EMAIL']['BODY']).";;"; }

	/* GPS adatok */
	if(is_array($_GET['GPS'])) { $_data = "GEO:TO:".in_qr($_GET['GPS']['LAT']).";SUB:".in_qr($_GET['GPS']['LON']).";BODY:".in_qr($_GET['GPS']['HEIGHT']); }

	/* WiFi adatok */
	if(is_array($_GET['WIFI'])) { $_data = "WIFI:T:".in_qr($_GET['WIFI']['T']).";S:".in_qr($_GET['WIFI']['S']).";P:".in_qr($_GET['WIFI']['P']).";;"; }


	include "qrlib.php";
	QRcode::png(in_qr($_data), false, $quality, $size, 1);

?>