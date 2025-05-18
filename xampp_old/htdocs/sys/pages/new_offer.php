<?php

if (isauth()) {
    $template = new Template();

    if ($_REQUEST['step'] == "intro") {

        if (isset($_REQUEST['copySourceID'])) {
            $_SESSION['offerwizard_source-offer-id'] = $_REQUEST['copySourceID'];

            $content = '
                <div style="font-size:16px; font-family:segoe ui,tahoma,verdana,helvetica,arial">' .
                    'A következõ pár lépésben a(z) ' . $_REQUEST['copySourceID'] . ' sorszámú ajánlatról fog másolatot készíteni. a megfelelő gomb választásával 
				   meghagyhatja az ajánlatban szereplő ügyfelet, vagy lecserélheti azt.
                    <br /><br />
                    <div style="width:100%; text-align:right">
                    <input type="button" onClick="window.location=\'?page=new_offer&lang=hun&step=select_recipient\'" value="tovább új céggel &gt;&gt;"</input><br />
                    <input type="button" onClick="window.parent.location=\'sys/offerrequest_createderivative.php?offerid=' . $_REQUEST['copySourceID'] . '\'" value="tovább a meglevő céggel &gt;&gt;"</input>
                </div>';
        } else {
            $content = '
                <div style="font-size:16px; font-family:segoe ui,tahoma,verdana,helvetica,arial">' .
                    'A következõ pár lépésben új árajánlatot fog készíteni.<br />Elõször ki kell válassza az 
                   ajánlatot kapó céget, majd egy ügyintézõt. Amennyiben szükség van rá, újakat is vehet
                   fel.<br />Az ügyfél kiválasztása után automatikusan megjelenik a szerkesztõoldal, az
                   ajánlatban szereplõ targoncák felvételére ott lesz lehetõség.
                </div>
                <br /><br />
                <div style="width:100%; text-align:right">
                    <input type="button" onClick="window.location=\'?page=new_offer&lang=hun&step=select_recipient\'" value="tovább &gt;&gt;"</input>
                </div>';
        }
    } else if ($_REQUEST['step'] == "select_recipient") {
        $inline = 1;
        include('companies.php');

        $content = $inline_content;
    } else if ($_REQUEST['step'] == "select_clerk") {
        $companyID = $_SESSION['offerwizard_company-id'];
        $companyInfo = get_company_by_id($companyID);

        $content = '
            Kiválasztott cég: <br /> <div style= "padding-left:12px; margin-bottom:20px; font-family:segoe ui, tahoma, verdana; font-size: 14px;">' .
                '<strong>' . $companyInfo['company_name'] . '</strong> <a href="?page=new_offer&lang=hun&step=select_recipient" style="margin-left:20px">másik választása</a><br />' .
                $companyInfo['company_zip'] . ' ' . $companyInfo['company_city'] . ', ' . $companyInfo['company_address'] . '<br />' .
                'tel: ' . fix_phone_number($companyInfo['company_phone'], $companyInfo['company_country']) . '<br />' .
                'fax: ' . fix_phone_number($companyInfo['company_fax'], $companyInfo['company_country']) . '<br />' .
                'email: ' . $companyInfo['company_email'] . '</div>';

        $content .= 'Ügyintézõ:<div style="padding-left:12px;">' .
                '<select id="user" style="width:400px;" onChange="ReloadUserInfo();">';
        $companyUsers = get_users_by_company($companyID);
        foreach ($companyUsers as $user) {
            if (!isset($userInfo))
                $userInfo = $user;
            $content .= '<option value="' . $user['users_id'] . '">(' . $user['users_id'] . ') ' . $user['users_realname'] . '</option>';
        }
        $content .= '</select>';

        $content .= '<input type="button" value="Új ügyintézõ felvitele" onclick="hs.htmlExpand($(\'new_company\'), {objectType: \'iframe\', align: \'center\', width: 600, height: 480}, {onClosed: function(){window.location.reload();}});"/>' .
                '<a id="new_company" style="display:none" href="?page=reg&inline&companyid=' . $companyID . '&lang=hun" ></a>' .
                '<div id="userInfo">' .
                'Név: ' . $userInfo['users_realname'] . '<br />' .
                'Beosztás: ' . $userInfo['users_role'] . '<br />' .
                'Email: ' . $userInfo['users_email'] . '<br />' .
                'Tel: ' . fix_phone_number($userInfo['users_phone'], $companyInfo['company_country']) . '<br />' .
                'Fax: ' . fix_phone_number($userInfo['users_fax'], $companyInfo['company_country']) . '<br />' .
                '<input type="button" value="Ügyintézõ szerkesztése" onclick="hs.htmlExpand($(\'edit_user\'), {objectType: \'iframe\', align: \'center\', width: 600, height: 480}, {onClosed: function(){window.location.reload();}});"/>' .
                '<a id="edit_user" style="display:none" href="sys/edit_user.php?uid=' . $userInfo['users_id'] . '&lang=hun" ></a>' .
                '</div>' .
                '</div>';

        $content .= '<div style="width:100%; text-align:right">' .
                '<input type="button" onClick="' .
                ((isset($_SESSION['offerwizard_source-offer-id'])) ? 'CopyOffer(' . $_SESSION['offerwizard_source-offer-id'] . ');' : 'CreateOffer();' ) .
                '" value="tovább a szerkesztõhöz &gt;&gt;"</input>' .
                '</div>';
    }
    else {
        
    }

    $companies = get_company_select();
    $variables = array("CONTENT" => $content);

    $template->assign_var_array($variables);
    $main_content = $template->compile("sys/lang/hun/new_offer");
    include("sys/tpl/multipage_popup.tpl");
}
?>