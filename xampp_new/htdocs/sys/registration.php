<?php

include_once("common.php");

include ('../recaptcha/recaptchalib.php');
$resp = recaptcha_check_answer($CAPTCHA['private_key'], $_SERVER["REMOTE_ADDR"], $_REQUEST["recaptcha_challenge_field"], $_REQUEST["recaptcha_response_field"]);

if (isset($_REQUEST['inline'])) {
    $captcha_valid = TRUE;
} else {
    $captcha_valid = $resp->is_valid;
}


if (!$captcha_valid) {


// What happens when the CAPTCHA was entered incorrectly

    $_SESSION['pending_registration'] = array(
        'REG_USERNAME' => $_REQUEST['username'],
        'REG_PASSWORD' => $_REQUEST['password'],
        'REG_PASSWORD_RE' => $_REQUEST['password_re'],
        'REG_REALNAME' => $_REQUEST['realname'],
        'REG_ROLE' => @$_REQUEST['role'],
        'REG_EMAIL' => $_REQUEST['email'],
        'REG_PHONE' => $_REQUEST['phone'],
        'REG_FAX' => $_REQUEST['fax'],
        'REG_COMPANY_NAME' => $_REQUEST['company_name'],
        'REG_COMPANY_ZIP' => $_REQUEST['company_zip'],
        'REG_COMPANY_ADDRESS' => $_REQUEST['company_address'],
        'REG_COMPANY_PHONE' => $_REQUEST['company_phone'],
        'REG_COMPANY_FAX' => $_REQUEST['company_fax'],
        'REG_COMPANY_EMAIL' => $_REQUEST['company_email'],
        'CAPTCHA_ERROR' => $language['reg:captcha_error']/* $resp->error */
    );
    redirect_in_site("?page=reg&lang=$lang");
} else {
// Your code here to handle a successful verification



    if (!loggedin() || isauth()) {
        $company = false;
        if (isset($_REQUEST['adduser'])) {
            $company = true;
// exit("fuck");
        }




        $result = register($company);

        if ($result != Register_Success) {
            $_SESSION['pending_registration'] = array(
                'REG_USERNAME' => $_REQUEST['username'],
                'REG_PASSWORD' => $_REQUEST['password'],
                'REG_PASSWORD_RE' => $_REQUEST['password_re'],
                'REG_REALNAME' => $_REQUEST['realname'],
                'REG_ROLE' => @$_REQUEST['role'],
                'REG_EMAIL' => $_REQUEST['email'],
                'REG_PHONE' => $_REQUEST['phone'],
                'REG_FAX' => $_REQUEST['fax'],
                'REG_COMPANY_NAME' => $_REQUEST['company_name'],
                'REG_COMPANY_ZIP' => $_REQUEST['company_zip'],
                'REG_COMPANY_ADDRESS' => $_REQUEST['company_address'],
                'REG_COMPANY_PHONE' => $_REQUEST['company_phone'],
                'REG_COMPANY_FAX' => $_REQUEST['company_fax'],
                'REG_COMPANY_EMAIL' => $_REQUEST['company_email'],
            );

            if (isset($_REQUEST['inline'])) {
                redirect_in_site("?page=reg&inline&lang=$lang&error=$result");
            } else {
                redirect_in_site("?page=reg&lang=$lang&error=$result");
            }
        } else if (!isauth()) {
            redirect_in_site("?page=login&lang=$lang");
        } else {
            if (isset($_REQUEST['inline']))
                print('<span style="margin-bottom: 12px; font-weight:bold; font-size:14px;">Ügyintézõ sikeresen felvéve.</span><br />A folytatáshoz zárja be ezt az űrlapot.<br />');
            else
                redirect_in_site("?page=admin&lang=$lang");
        }
    }
    else {
        redirect_in_site("?page=$default_page&lang=$lang");
    }
}
?>