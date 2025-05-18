<?php

$template = new Template();
include (getcwd() . '/recaptcha/recaptchalib.php');
$variables = array(
    "finished" => $language['finishedjobs'],
    "zoom" => $language['clicktozoom'],
    "imagelink" => $promo['big_link'],
    "defaultpic" => $promo['small_link'],
    "defaultid" => $promo['promo_id'],
    "RECAPTCHA" => recaptcha_get_html($CAPTCHA['public_key'])
);

if (isset($_SESSION['pending_ajanlatkeres'])) {
        foreach ($_SESSION['pending_ajanlatkeres'] as $key => $value) {
            $variables[$key] = $value;
        }
    }
    unset($_SESSION['pending_ajanlatkeres']);

$template->assign_var_array($variables);
$main_content = $template->compile("sys/lang/" . $lang . "/root_trucks");

include("sys/tpl/main.tpl");
?>