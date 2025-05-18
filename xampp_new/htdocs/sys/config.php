<?php
ini_set('include_path', '.');
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../').'/';
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);

global $CFG;
/*
$db=array("user"=>"nweb_saxonrt_eu",
    "password"=>"saxonasd",
    "host"=>"localhost",
    "dbname"=>"nweb_saxonrt_eu"
);

$db=array("user"=>"saxon_newdbuser",
    "password"=>"resubd",
    "host"=>"localhost",
    "dbname"=>"nweb_saxonrt_eu"
);

$db=array("user"=>"saxon_newdbuser42",
    "password"=>"resubd",
    "host"=>"localhost",
    "dbname"=>"nweb_saxonrt_eu"
);

$db=array("user"=>"0106_saxon",
    "password"=>"4FpnFi6L-eL",
    "host"=>"localhost",
    "dbname"=>"0106_saxon"
);
*/

$db=array("user"=>"root",
    "password"=>"",
    "host"=>"localhost",
    "dbname"=>"saxonrt"
);

//itt csak a default page list, a language mellett meg letiltjuk ami nem kell...
$pages=array("aktualis"=>1,
    "intro"=>2,
    "rolunk"=>1,
    "targoncak"=>1,
    "raklapemelok"=>1,
    "adapterek"=>1,
    "alkatreszek"=>1,
    "szerviz"=>1,
    "berlet"=>1,
    "root_rental"=>2,
    "elerhetoseg"=>1,
    "email"=>2,
    "usercp"=>2,
    "login"=>2,
    "hibabe"=>2,
    "reg"=>2,
    "offer_requests"=>2,
    "offer_requests_edit"=>2,
    "offer_requests_createderivative"=>2,
    "new_offer"=>2,
    "admin"=>2,
    "truckman_new"=>2,
    "truckman_imageeditor"=>2,
    "truckman_edit"=>2,
    "truckman_viewsold"=>2,
    "flyer_editor"=>2,
    "flyer_editor_0"=>2,
    "flyer_editor_1"=>2,
    "companies"=>2,
    "users"=>2,
    "admin_edit_make"=>2,
    "admin_edit_type"=>2,
    "admin_edit_functions"=>2,
    "admin_edit_location"=>2,
    "admin_select_daily_special"=>2,
    "admin_edit_auto_spec_offer"=>2,
    "promo_edit"=>2,
    "root_parts"=>2,
    "root_service"=>2,
    "root_trucks"=>2,
    "siteFront"=>2,
    "admin_select_featured"=>2,
    "admin_edit_homepage"=>2,
    "toplist_edit" => 2,
    "toplist_edit_search" => 2,
    "admin_edit" => 2,
    "admin_pages" => 2,
    "load" => 2,
    "print_location" => 2,
    "print_qr" => 2
);
$CFG=Array();
$CFG['db']=$db;
$CFG['pages']=$pages;
$CFG['config']=$config=array("server_name"=>$_SERVER['HTTP_HOST']."/","script_path"=>"");
$CFG['restricted']=$restricted=array("login");
$CFG['default_page']=$default_page="siteFront";
$CFG['default_lang']=$default_lang="hun";
$CFG['available_langs']=$available_langs=array("hun","ger","eng");
$CFG['itemsperpage']=$itemsperpage=15;
$CFG['copyright']=$copyright="";
$CFG['trackingsnippet']='
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-27705124-1\']);
  _gaq.push([\'_setDomainName\', \'saxonrt.hu\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>';
$CAPTCHA['public_key'] = '6LdAmdcSAAAAAOmXc0bbnJW1t4AZB2Vq0dZmEFf-';
$CAPTCHA['private_key'] = '6LdAmdcSAAAAAFe-PyH1D347m0vJEyt1pevX-IQC';
if(!is_array($_REQUEST['terstatus'])) { $_REQUEST['terstatus'] = Array(); }
if(is_array($_REQUEST['terstatus']) AND count($_REQUEST['terstatus'])>0 AND is_array($_REQUEST['__terstatus'])) { $_REQUEST['__terstatus'] = $_REQUEST['terstatus']; }
if(!is_array($_REQUEST['__terstatus'])) { $_REQUEST['__terstatus'] = Array(); }

$_ENV['terstatus'] = Array();
$_ENV['terstatus'][0] = 'Raktáron levő';
$_ENV['terstatus'][1] = 'Előrendelt';
$_ENV['terstatus'][2] = 'Bérbeadva';
$_ENV['terstatus'][3] = 'Foglalt-Eladás alatt';
$_ENV['terstatus'][4] = 'Eladva';
$_ENV['terstatus'][5] = 'Bizományban';
$_ENV['terstatus'][6] = 'Elbontva';


function is_mobile() {
	return ((preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])) ? (true) : (false));
}

stream_context_set_default([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
        "allow_self_signed" => true
    ]
]);



?>