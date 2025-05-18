<?php /* Készítő: H.Tibor */ $_ENV["SiteStart"]="JSON";
include(realpath("./@config.php"));
include(realpath("./@loader.php"));
header("Content-type: application/json; charset=utf-8");
print(json_encode($_ENV['JSON'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

?>