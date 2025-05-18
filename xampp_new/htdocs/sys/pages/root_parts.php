<?php

$template = new Template();
include (getcwd() . '/recaptcha/recaptchalib.php');
$variables = array(
    "finished" => $language['finishedjobs'],
    "zoom" => $language['clicktozoom'],
    "imagelink" => $promo['big_link'],
    "defaultpic" => $promo['small_link'],
    "defaultid" => $promo['promo_id'],
    "RECAPTCHA" => recaptcha_get_html($CAPTCHA['public_key']),
    "count" => 4,
    "part" => ''
);
for ($i = 1; $i < $variables['count']; $i++) {
    $variables['part'] .= '
<tr>
	<td style="text-align:right;margin-right:8px;width:120px">
	alkatrész ' . $i . ' :
	</td>
	<td>
            <input type="text" id="part[' . $i . '][name]" name="part[' . $i . '][name]" style="width:240px" /> <br />
	</td>
	<td>
            <input type="text" id="part[' . $i . '][id]" name="part[' . $i . '][id]" style="width:120px" /> <br />
	</td>
	<td>
            <input type="text" id="part[' . $i . '][count]" name="part[' . $i . '][count]" style="width:80px" /> <br />
	</td>
</tr>
';
}

if (isset($_SESSION['pending_alkatreszrendeles'])) {
    foreach ($_SESSION['pending_alkatreszrendeles'] as $key => $value) {
        if ($key == 'part') {
            $variables['part'] = '';
            foreach ($value as $rownum => $data) {
                $variables['part'] .= '
<tr>
	<td style="text-align:right;margin-right:8px;width:120px">
	alkatrész ' . $rownum . ' :
	</td>
	<td>
            <input type="text" id="part[' . $rownum . '][name]" name="part[' . $rownum . '][name]" style="width:240px" value="' . $data['name'] . '"/> <br />
	</td>
	<td>
            <input type="text" id="part[' . $rownum . '][id]" name="part[' . $rownum . '][id]" style="width:120px" value="' . $data['id'] . '"/> <br />
	</td>
	<td>
            <input type="text" id="part[' . $rownum . '][count]" name="part[' . $rownum . '][count]" style="width:80px" value="' . $data['count'] . '"/> <br />
	</td>
</tr>
';
            }
        } else {
            $variables[$key] = $value;
        }
    }
    $variables['count'] = count($_SESSION['pending_alkatreszrendeles']['part'])+1;
}

//print_r($variables);

unset($_SESSION['pending_alkatreszrendeles']);

$template->assign_var_array($variables);

$main_content = $template->compile("sys/lang/" . $lang . "/root_parts");

include("sys/tpl/main.tpl");
?>