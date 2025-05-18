<?php

include("common.php");
global $language, $sql;

$lang = 'hun';

header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$mysql = get_connection();
$mysql->execute($sql['setutf']);
$stmt = $mysql->prepare($sql['excel_get-sum']);
$stmt->bind_params($lang);

if ($stmt->execute()) {
    $row = 2;
    $result = $stmt->fetch_all();

    for ($i = 0; $i < count($result); $i++) {
        $row++;

        $stmt = $mysql->prepare($sql['excel_get-trucks_2date']);
        $stmt->bind_params($lang, $result[$i]['ID'], $result[$i]['ispart']);

        if ($stmt->execute()) {
            $trucks = $stmt->fetch_all();
            foreach ($trucks as $truck) {
                if ($truck['truck_saxon-id'] != '') {
                    $date = date_create($truck['truck_date']);
                    $date = date_format($date, 'Y-m-d');
                    //$date= date_format($date, 'Y-m-d H:i:s');
                    echo '
                    <url>
                        <loc>https://www.saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=hun&amp;id=' . $truck['truck_id'] . '</loc>
                    </url>
                    ';
                }
            }
        }
    }
}

echo '</urlset>';
?>