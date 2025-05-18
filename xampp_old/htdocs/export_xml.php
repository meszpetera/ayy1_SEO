<?php

//error_reporting(0);
include_once("sys/common.php");

if (( isset($_GET['list']) && intval($_GET['list']) > 0 )) {
    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['export:trucks']);
    $stmt->bind_params("eng", intval($_GET['list']));
    //echo $stmt->last_query();


    header("Content-Type:text/xml");
    if ($stmt->execute()) {
        $truck = $stmt->fetch_all();
        echo '<?xml version="1.0" encoding="UTF-8"?>
<ProductList>' . "\n";
        foreach ($truck as $item) {
            echo '  <ProductItem>' . "\n";
            foreach ($item as $k => $v) {
                $k = str_replace('truck_', '', $k);
                if ($k == 'default-image') {
                    $v = 'http://www.saxonrt.hu/img/trucks/' . $v;
                }
                $v = '<![CDATA[' . $v . ']]>';
                echo '      <' . $k . '>' . $v . '</' . $k . '>' . "\n";
            }
            echo '  </ProductItem>' . "\n";
        }
        echo '</ProductList>';
    }
} /* elseif (isset($_GET['type']) && $_GET['type'] == 'parts') {
  $mysql = get_connection();
  $mysql->execute($sql['setutf']);

  $stmt = $mysql->prepare($sql['export:parts']);
  $stmt->bind_params("eng");

  header("Content-Type:text/xml");
  if ($stmt->execute()) {
  $truck = $stmt->fetch_all();
  echo '<?xml version="1.0" encoding="UTF-8"?>
  <ProductList>' . "\n";
  foreach ($truck as $item) {
  echo '  <ProductItem>' . "\n";
  foreach ($item as $k => $v) {
  $k = str_replace('truck_', '', $k);
  if ($k == 'default-image') {
  $v = 'http://www.saxonrt.hu/img/trucks/' . $v;
  }
  $v = '<![CDATA[' . $v . ']]>';
  echo '      <' . $k . '>' . $v . '</' . $k . '>' . "\n";
  }
  echo '  </ProductItem>' . "\n";
  }
  echo '</ProductList>';
  }
  } */ else {

    include_once('export_xml_text.php');
}
?>