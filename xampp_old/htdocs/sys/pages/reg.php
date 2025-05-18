<?php

if (loggedin() && !isauth()) {
    redirect_in_site("?page=$default_page&lang=$lang");
} else if (isauth()) {
    $template = new Template();
    $companies = get_company_select();

    if (isset($_REQUEST['inline'])) {
        $inline = 1;
    }



    if (!isset($inline)) {
        $variables = array(
            "REG" => $language['reg:register'],
            "ERROR" => isset($_REQUEST['error']) ? $language['regerror'][$_REQUEST['error']] : "",
            "COMPANIES" => $companies
        );


        $template->assign_var_array($variables);
        $main_content = $template->compile("sys/lang/hun/add_user");
        include("sys/tpl/main.tpl");
    } else {
        $variables = array(
            "REG" => "Mentés",
            "ERROR" => isset($_REQUEST['error']) ? $language['regerror'][$_REQUEST['error']] : "",
            "COMPANIES" => $companies
        );
        if (isset($_SESSION['pending_registration'])) {
            foreach ($_SESSION['pending_registration'] as $key => $value) {
                $variables[$key] = $value;
            }
        }

        unset($_SESSION['pending_registration']);
        //print_r($variables);
        $template->assign_var_array($variables);
        $main_content = $template->compile("sys/lang/hun/add_user_inline");
        include("sys/tpl/multipage_popup.tpl");
    }
} else {

    $template = new Template();

    include (getcwd() . '/recaptcha/recaptchalib.php');

    $variables = array(
        "REG" => $language['reg:register'],
        "ERROR" => isset($_REQUEST['error']) ? $language['regerror'][$_REQUEST['error']] : "",
        "RECAPTCHA" => recaptcha_get_html($CAPTCHA['public_key'])
    );
    if (isset($_SESSION['pending_registration'])) {
        foreach ($_SESSION['pending_registration'] as $key => $value) {
            $variables[$key] = $value;
        }
    }
    unset($_SESSION['pending_registration']);


    $template->assign_var_array($variables);


    $main_content = $template->compile("sys/lang/$lang/reg");
    include("sys/tpl/main.tpl");
}
?>