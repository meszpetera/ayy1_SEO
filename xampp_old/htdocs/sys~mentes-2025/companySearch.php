<?php 
    include_once("common.php");
    if(isauth())
    {
		$inline = 1;
		$result = get_companies($_REQUEST['searchString']);
		
		echo (($result === 0) ? "Nincs találat" : $result);
	}
?>