<?php
    $context = stream_context_create([
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false
        ]
    ]);

    $info = null;

    function forceHttp($url) {
        return preg_replace("/^https?:\/\/localhost/", "https://saxonrt.hu", $url);
    }
    

    function getCurrentDailyOffer()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['daily_offer:query_current']);



        if($stmt->execute())

        {

            if ($stmt->num_rows() == 0)

            $result = array();

            else

            $result = $stmt->fetch_all();

        }



        return $result[0]['truckID'];

    }



    function getAutoSpecOfferTrucks()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['auto_spec_offer:query_list']);



        if($stmt->execute())

        {

            if ($stmt->num_rows() == 0)

            $result = array();

            else

            $result = $stmt->fetch_all();

        }



        return $result;

    }



    function getAutoSpecOfferLastDate()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['auto_spec_offer:query_last_date']);



        if($stmt->execute())

        {

            $result = $stmt->fetch_all();

        }



        return $result[0]['value'];

    }



    function setAutoSpecOfferLastDate()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['auto_spec_offer:update_last_date']);

        $stmt->bind_params(date('Y-m-d'));



        $stmt->execute();

    }



    function getAutoSpecOfferLastFileName()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['auto_spec_offer:query_last_file_name']);



        if($stmt->execute())

        {

            $result = $stmt->fetch_all();

        }



        return $result[0]['value'];

    }



    function addAutoSpecOffer()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['auto_spec_offer:add_trucks']);

        $stmt->bind_params(join(', ', $_SESSION['basket']));





        if($stmt->execute())

            return true;

        else

            return false;

    }



    function removeAutoSpecOffer($t)

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['auto_spec_offer:remove_truck']);

        $stmt->bind_params($t);





        if($stmt->execute())

            return true;

        else

            return false;

    }



    function getRandomPromo()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['promo:get']);

        $stmt->bind_params();





        if($stmt->execute())

        {

            $arr = $stmt->fetch_all();

            $id1 = $arr[mt_rand(0, count($arr))];

            $id2 = $arr[mt_rand(0, count($arr))];

            $id3 = $arr[mt_rand(0, count($arr))];



            return array($id1['truck_id'], $id2['truck_id'], $id3['truck_id']);

        }

        else

            return false;

    }



    function fitImageIntoRect($imageFileName, $targetWidth, $targetHeight)

    {


        #$imageFileName = forceHttp($imageFileName);
        $imageFileName = str_replace('localhost', 'saxonrt.hu', $imageFileName);
        list($width, $height, $type, $attr) = getimagesize($imageFileName);

        $ratio1 = $targetWidth/$width;

        $ratio2 = $targetHeight/$height;

        $ratio = ($ratio1 > $ratio2) ? $ratio2 : $ratio1;



        return array("ratio" => $ratio,

                     "width" => $width*$ratio,

                     "height" => $height*$ratio);

    }



    function getFeatured()

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt = $mysql->prepare($sql['featured:get']);



        if($stmt->execute())

        {

            $arr = $stmt->fetch_all();



            return array($arr[0]['ID1'], $arr[0]['ID2'], $arr[0]['ID3'], $arr[0]['ID4']);

        }

        else

            return false;

    }



    function setFeatured($truck_id1, $truck_id2, $truck_id3, $truck_id4)

    {

        global $sql;

        global $lang;

        global $language;



        $mysql = get_connection();

        $result = array();

        $mysql->execute($sql['setutf']);



        $stmt1 = $mysql->prepare($sql['featured:set']);

        $stmt1->bind_params($truck_id1, 1);

        $stmt2 = $mysql->prepare($sql['featured:set']);

        $stmt2->bind_params($truck_id2, 2);

        $stmt3 = $mysql->prepare($sql['featured:set']);

        $stmt3->bind_params($truck_id3, 3);

        $stmt4 = $mysql->prepare($sql['featured:set']);

        $stmt4->bind_params($truck_id4, 4);



        if($stmt1->execute() && $stmt2->execute() && $stmt3->execute() && $stmt4->execute())

            return true;

        else

            return false;

    }



    function pushFeatured($truck_id)

    {

        $current = getFeatured();

        setFeatured($truck_id, $current[0],$current[1],$current[2]);

    }

?>