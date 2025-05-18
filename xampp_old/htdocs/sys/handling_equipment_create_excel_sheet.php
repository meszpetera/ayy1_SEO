<?php
  ini_set("include_path", "./");
  include("Spreadsheet/Excel/Writer.php");
  include("common.php");

  $price = isset($_REQUEST['showprice']) && $_REQUEST['showprice'] == '1' ? true : false;
	$showcomment = isset($_REQUEST['showcomment']) && $_REQUEST['showcomment'] == '1' ? true : false;
	$celltomerge = $price ? 11 : 10;

	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->send('saxon_trucks_and_parts.xls');

	//trucks
	{
		$worksheet =& $workbook->addWorksheet('Saxon Zrt. TRUCKS');
		$worksheet->setLandscape();
		$worksheet->setPrintScale(96);
		$worksheet->setMargins(0.4);
		$worksheet->freezePanes(array(1, 0));
		$worksheet->setColumn(0, 0, 6); $worksheet->write(0, 0, utf8_decode($language['saxon-id']));
		$worksheet->setColumn(0, 1, 14); $worksheet->write(0, 1, utf8_decode($language['make']));
		$worksheet->setColumn(0, 2, 18); $worksheet->write(0, 2, utf8_decode($language['model']));
		$worksheet->setColumn(0, 3, 11); $worksheet->write(0, 3, utf8_decode($language['fuel']));
		$worksheet->setColumn(0, 4, 4); $worksheet->write(0, 4, utf8_decode($language['year']));
		$worksheet->setColumn(0, 5, 6); $worksheet->write(0, 5, utf8_decode($language['max-load']));
		$worksheet->setColumn(0, 6, 6); $worksheet->write(0, 6, utf8_decode($language['hours-used']));
		$worksheet->setColumn(0, 7, 11); $worksheet->write(0, 7, utf8_decode($language['max-height']));
		$worksheet->setColumn(0, 8, 12); $worksheet->write(0, 8, utf8_decode($language['location']));
		$worksheet->setColumn(0, 9, 13); $worksheet->write(0, 9, utf8_decode($language['status']));

		if($price)
		{
			$worksheet->setColumn(0, 10, 07); $worksheet->write(0, 10, utf8_decode($language['cost']));  
		}

		//if($showcomment)
		{
			$worksheet->setColumn(0, 10 + ($price ? 1 : 0), 20); $worksheet->write(0, 10 + ($price ? 1 : 0), utf8_decode($language['comment']));  
		}

		$mysql = get_connection();
		$mysql->execute($sql['setutf']);

		$format_header =& $workbook->addFormat();
		$format_header->setFontFamily('Arial');
		$format_header->setSize(12);
		$format_header->setBold(1);
		$workbook->setCustomColor(32, 210, 210, 210);
		$format_header->setFgColor(32);

		$format_body =& $workbook->addFormat();
		$format_body->setFontFamily('Arial');
		$format_body->setSize(8);

		$stmt = $mysql->prepare($sql['excel_get-types_2']);
		$stmt->bind_params('eng', '0');

		if($stmt->execute())
		{
			$row = 2;
			$result = $stmt->fetch_all();

			for ($i = 0; $i < count($result); $i++)
			{

				$stmt = $mysql->prepare($sql['excel_get-trucks_2_R']);
				$stmt->bind_params('eng', $result[$i]['ID'], '0');
				if($stmt->execute())
				{
					$trucks = $stmt->fetch_all();
                    
                    if (isset($trucks[0]['truck_saxon-id']))
                    {
                        $worksheet->writeString($row, 0, utf8_decode($result[$i]['value']), $format_header); 
                        $worksheet->mergeCells($row, 0, $row, $celltomerge);
                        $row++;
                        
                        foreach ($trucks as $truck)
                        {
                            if ($truck['truck_saxon-id'] != '')
                                $worksheet->writeUrl ($row, 0, 'https://saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=hun&id=' . $truck['truck_id'], $truck['truck_saxon-id'], $format_body);
                            $worksheet->write($row, 1, $truck['truck_make'], $format_body);
                            $worksheet->write($row, 2, $truck['truck_model'], $format_body);
                            $worksheet->write($row, 3, $truck['truck_fuel'], $format_body);
                            $worksheet->write($row, 4, $truck['truck_year'], $format_body);
                            $worksheet->write($row, 5, $truck['truck_max-load'], $format_body);
                            $worksheet->write($row, 6, $truck['truck_hours-used'], $format_body);
                            $worksheet->write($row, 7, $truck['truck_max-height'], $format_body);
                            $worksheet->write($row, 8, utf8_decode($truck['truck_location']), $format_body);
                            $worksheet->write($row, 9, $truck['truck_status'], $format_body);
                            if($price)
                                $worksheet->write($row, 10, $truck['truck_cost'], $format_body);
                            if($showcomment)
                                $worksheet->write($row, 10 + ($price ? 1 : 0), $truck['truck_short-comment'], $format_body);
                            $row++;
                        }

                        $row++;
                        $row++;
                    }
				}
			}
		}
	}
	$workbook->close();
	
?>