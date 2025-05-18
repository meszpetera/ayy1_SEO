<?php /* Készítő: H.Tibor */ if(!$_ENV['SiteStart']) { header('HTTP/1.0 404 Not Found',false,404); header('Location: /'); exit(); }
class ReURL {
	static function remove_accent($str) {
		$a=array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','Ļ','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','Ż','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǎ','ǎ','Ǐ','ǐ','Ǒ','ǒ','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ǻ','ǻ','Ǽ','ǽ','Ǿ','ǿ');
		$b=array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
		return str_replace($a,$b,$str);
	}
	static function decode($str) {
		if(strstr($str,'#')) { $_str=explode('#',$str); $str=$_str[0]; }
		if(strstr($str,'?')) { $_str=explode('?',$str); $str=$_str[0]; }
		$str=ReURL::remove_accent($str);
		if(substr($str,-1) == '/') { $str=substr($str,0,-1); }
		/*$remove=Array('/index.html','/index.php','/index.ajax','/index.json','.php','.html','.ajax','.json','.xml','.txt');*/
		$remove=Array('/index.html','/index.php','/index.ajax','/index.json','.html','.ajax','.json','.xml','.txt');
		$str=str_replace(Array('%20',' '),'-',$str);
		$str=str_replace($remove,'',$str);
		if(substr($str,-1) == '/') { $str=substr($str,0,-1); }
		$str=strtolower(preg_replace(array('/[^a-zA-Z0-9\-\+\.\/\_ -]/','/^-|-$/'),array('-','-'),$str));
		for($a=0;(strstr($str,'__')AND $a<100);$a++){$str=str_replace('__','_',$str);}
		for($a=0;(strstr($str,'--')AND $a<100);$a++){$str=str_replace('--','-',$str);}
		for($a=0;(strstr($str,'++')AND $a<100);$a++){$str=str_replace('++','+',$str);}
		return($str);
	}
}
function utf8urldecode($str){ return ReURL::decode(htmlspecialchars_decode($str));}
function utf8reurldecode($str) {
	$str=str_replace(Array('/','"',"'",'&amp;','&quot;','&'),'-',$str);
	$str=str_replace('&','-',$str);
	$str=ReURL::decode($str);
	return $str;
}





if($_SERVER['REQUEST_URI']) {
	if(substr($_SERVER['REQUEST_URI'],0,5)=='/api/') {
		$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'],4);
	}
	$rURI = explode('?',$_SERVER['REQUEST_URI']);
	$_ENV['REURL']=ReURL::decode($_SERVER['REQUEST_URI']);
	$_ENV['REURL']=explode('/',$_ENV['REURL']);
} else if($_SERVER['REDIRECT_URL']) {
	$_ENV['REURL']=ReURL::decode($_SERVER['REDIRECT_URL']);
	$_ENV['REURL']=explode('/',$_ENV['REURL']);
}
?>