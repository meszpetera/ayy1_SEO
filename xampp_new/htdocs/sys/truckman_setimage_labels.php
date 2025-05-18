<?php

include_once("common.php");
//error_reporting(E_ALL);
if (isauth()) {
    if (isset($_REQUEST['truckid']) && isset($_REQUEST['imageuniqueid'])) {
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['truck_getimageByUniqueId']);
        $stmt->bind_params($_REQUEST['imageuniqueid']);
        if ($stmt->execute()) {
            $result = $stmt->fetch_all();
        }

        $source = substr($result[0]['image_filename'], 0, strrpos($result[0]['image_filename'], '.')) . '_max' . substr($result[0]['image_filename'], strrpos($result[0]['image_filename'], '.'));

        $destination = $result[0]['image_filename'];

        if (file_exists(getcwd() . '/../img/trucks/' . $result[0]['image_filename'])) {
            unlink(getcwd() . '/../img/trucks/' . $result[0]['image_filename']);
        }

        include_once 'image_moo/image_moo.php';
        $moo = new Image_moo();
        $moo->load(getcwd() . '/../img/trucks/' . $source)->resize(320, 240);

        if ($_REQUEST['illustration'] == 1) {
            $moo->load_watermark(getcwd() . '/../img/img_illusztracio.png')->watermark(7, 0);
        }

        if ($_REQUEST['notworking'] == 1) {
            $moo->load_watermark(getcwd() . '/../img/img_nemmukodik.png')->watermark(1, 0);
        }

        if ($moo->errors) {
            print $moo->display_errors();
        }

        $moo->save(getcwd() . '/../img/trucks/' . $destination);

        if (isSet($_REQUEST['illustration'])) {
	        $stmt = $mysql->prepare($sql['truck_setimage_illustration']);
	        $stmt->bind_params($_REQUEST['illustration'], $_REQUEST['imageuniqueid']);
	        if ($stmt->execute())
	            truck_updated($_REQUEST['truckid']);
        }

        if (isSet($_REQUEST['notworking'])) {
	        $stmt = $mysql->prepare($sql['truck_setimage_notworking']);
	        $stmt->bind_params($_REQUEST['notworking'], $_REQUEST['imageuniqueid']);

	        if ($stmt->execute())
	            truck_updated($_REQUEST['truckid']);
        }
    }
    if ($_REQUEST['returnto'] == 'truckeditor')
        redirect_in_site("?page=truckman_edit&lang=hun&truckid=" . $_REQUEST['truckid']);
    else
        redirect_in_site("?page=truckman_imageeditor&lang=hun&truckid=" . $_REQUEST['truckid']);
}
?>