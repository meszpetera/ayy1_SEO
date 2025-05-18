<?php

include_once("common.php");

$field = $_REQUEST['field'];
$ispart = isset($_REQUEST['ispart']) && $_REQUEST['ispart'] != "" ? $_REQUEST['ispart'] : 0;
$issimple = isset($_REQUEST['issimple']) && $_REQUEST['issimple'] != "" ? $_REQUEST['issimple'] : 0;

if (($field == "akcios") || ($field == "make") || ($field == "fuel") || ($field == "saxon-id") || ($field == "status") ||
        ($field == "location") || ($field == "function") || ($field == "cost") || ($field == "max-load") || ($field == "type")) {

    $filterlist = get_filter_list($field, $ispart);
    if ($issimple == 1) {

        $result .= "<option value=\"\">" . $language[$field] . "</option>";
        /*
          if ($field == "make" ) {// && $lang == "eng"
          //$result .= "<option value=\"\">" . (($ispart) ? "Function" : "Manufacturer") . "</option>";
          $result .= "<option value=\"\">" . (($ispart) ? $language['function'] : $language['make']) . "</option>";
          } else {
          $result .= "<option value=\"\">" . $language[$field] . "</option>";
          }
         */
    }
    foreach ($filterlist as $filteritem){
        if (isset($filteritem['ID'])){
            $result .= "<option value=\"" . $filteritem['ID'] . "\">" . $filteritem['value'] . "</option>";
        }
        else{
            $result .="";
        }
    }
} else {
    $result = "<option value=\"ERR\">ERROR: filtering not implemented for this field (" . $field . ")</option>";
}
echo $result;
?>