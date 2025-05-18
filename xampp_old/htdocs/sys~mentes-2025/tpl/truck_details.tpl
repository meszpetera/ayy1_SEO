<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <?php
    global $truck, $language, $CFG, $lang;
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="text/javascript" src="../js/framework/prototype.js"></script>
        <script type="text/javascript" src="../js/framework/scriptaculous.js"></script>
        <script type="text/javascript" src="../js/aktualis_truckdetails.js?<?php print(date('Ymd')); ?>"></script>
        <title>Targonca <?php print($truck[0]['truck_year'].' '.$truck[0]['truck_make']." ".$truck[0]['truck_model']." ".$truck[0]['truck_type']." ".$truck[0]['truck_fuel']); ?> Truck</title>
        <meta name="description" content="<?php print($truck[0]['truck_type']." ".$truck[0]['truck_model']." ".$truck[0]['truck_fuel']); ?> Truck">
        <meta name="keywords" content="Targonca, Truck, forklift">
        <style type="text/css">
            body{
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            .dLeftColumn{
                float: left;
                width: 140px;
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                line-height:1.5;
            }

            .dRightColumn{
                float: left;
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                line-height:1.5;
            }

            .dPrevImage{
                width: 120px;
                float: left;
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }

            .dImageID{
                width: 80px;
                float: left;
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                text-align: center;
            }

            .dNextImage{
                width: 120px;
                float: left;
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                text-align: right;
            }
            .print {
                margin-left:12px;
            }

            .print a{
                width: 120px;
                font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                height:24px;
                line-height:24px;
                text-align:center;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                text-decoration:none;
                color:#fff;
                display:block;
                background-color:#8FBCB9;

            }
            .print a:hover{
                background-color:#7AA3A1;
            }
            .kiemelt{
                font-weight: bold;
            }
						#imagediv > a { position: relative; display: inline-block; }
						#imagediv > a[label]::before {
							content: attr(label);
							display: block;
							position: absolute;
							left: -25px; top: 108px;
							width: 370px; height: auto;
							padding: 0px 0px;
							text-align: center;
							transform: rotate(-35deg);
							color: #FFF;
							font-size: 20px;
							border-radius: 20px;
							text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
							background-color: rgba(255, 0, 0, 0.5);
							text-align: center;
							line-height: 1.5em;
    					box-shadow: 0px 0px 2px #000000;
						}
        </style>
        <?php echo $CFG['trackingsnippet']; ?>
		<?php
			if(is_mobile()) {
				print('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=6.0, user-scalable=1" />');
			}
		?>
    </head>
    <body style=" background-color:#c6dddc; padding-bottom:50px;">

		<?php
			if(is_mobile()) {
				// print('<button style="float: right;" onclick="window.close();">Bezár</button>');
				print('<button style="float: right; font-size: 1.75em;" onclick="window.history.back();">Bezár</button>');
			}
		?>
        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 24px; padding: 0 0 0 0; margin: 0 0 0 0; text-align:center;">
            <?php print($language['truck-details_title-pre'] . $truck[0]['truck_saxon-id'] . $language['truck-details_title-post']); ?>
        </p>

        <p class="print">
            <a href="aktualis_truckdetails_createpdf.php?truckid=<?php print($truck[0]['truck_id']); ?>&amp;lang=<?php print($lang); ?>" target="blank"><?php print($language['truck-details_print']); ?></a>
       	<?php
       		if ((loggedin() && isauth()) OR 1) {
       			print('
			    		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
							<script src="/js/hmtl-print.js"></script>
							<iframe id="printf" name="printf" src="/blank.html" style="display:none;"></iframe><img src="/img/qr.png" alt="" style="max-height:24px;vertical-align:baseline;cursor:pointer;position:absolute;top:15px;right:100px;" onclick=\'printTruckQR(`'.($truck[0]['truck_saxon-id']).'`,'.(json_encode($truck[0],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)).');\' />
						');
					}
				?>
        </p>

        <table style="float:left;margin-left:12px;width:360px;border:none;">
            <tr><td><?php print($language['truck-details_manufacturer']); ?>:</td>
                <td><span class="kiemelt"><?php print($truck[0]['truck_make']); ?></span></td>
            </tr>
            <tr><td><?php print($language['truck-details_model']); ?>:</td>
                <td><span class="kiemelt"><?php print($truck[0]['truck_model']); ?></span></td>
            </tr>
            <tr><td><?php print($language['truck-details_type']); ?>:</td>
                <td><span class="kiemelt"><?php print($truck[0]['truck_type']); ?></span></td>
            </tr>
            <tr><td><?php print($language['truck-details_function']); ?>:</td>
                <td><?php print($truck[0]['truck_function']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_status']); ?>:</td>
                <td><?php print($truck[0]['truck_status']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_fuel']); ?>:</td>
                <td><?php print($truck[0]['truck_fuel']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_max-load']); ?>:</td>
                <td><?php print($truck[0]['truck_max-load']); ?> kg</td>
            </tr>
            <tr><td><?php print($language['truck-details_max-height']); ?>:</td>
                <td><?php print($truck[0]['truck_max-height']); ?></td>
            </tr>


            <tr>
                <td><?php print($language['truck-details_full-height']); ?>:</td>
                <td><?php print($truck[0]['truck_full-height']); ?></td>
            </tr>
            <tr>
                <td><?php print($language['truck-details_cabin-height']); ?>:</td>
                <td><?php print($truck[0]['truck_cabin-height']); ?></td>
            </tr>
            <tr>
                <td><?php print($language['truck-details_length']); ?>:</td>
                <td><?php print($truck[0]['truck_length']); ?></td>
            </tr>
            <tr>
                <td><?php print($language['truck-details_width']); ?>:</td>
                <td><?php print($truck[0]['truck_width']); ?></td>
            </tr>
            <tr>
                <td><?php print($language['truck-details_lifting-column-height']); ?>:</td>
                <td><?php print($truck[0]['truck_lifting-column-height']); ?></td>
            </tr>






            <tr><td><?php print($language['truck-details_powered-wheel']); ?>:</td>
                <td><?php print($truck[0]['truck_powered-wheel']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_steered-wheel']); ?>:</td>
                <td><?php print($truck[0]['truck_steered-wheel']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_engine']); ?>:</td>
                <td><?php print($truck[0]['truck_engine']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_drivetrain']); ?>:</td>
                <td><?php print($truck[0]['truck_drivetrain']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_hours-used']); ?>:</td>
                <td><?php print($truck[0]['truck_hours-used']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_year']); ?>:</td>
                <td><?php print($truck[0]['truck_year']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_serial']); ?>:</td>
                <td><?php print($truck[0]['truck_serial']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_weight']); ?>:</td>
                <td><?php print($truck[0]['truck_weight']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_forks']); ?>:</td>
                <td><?php print($truck[0]['truck_forks']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_extras']); ?>:</td>
                <td><?php print($truck[0]['truck_extras']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_warranty']); ?>:</td>
                <td><?php print($truck[0]['truck_warranty']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_expected-arrival']); ?>:</td>
                <td><?php print($truck[0]['truck_expected-arrival']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_location']); ?>:</td>
                <td><?php print($truck[0]['truck_location']); ?></td>
            </tr>
            <tr><td><?php print($language['truck-details_cost']); ?>:</td>
                <td style="font-size: 14pt;"><?php print((special_offer_active($truck[0]) ? '<span style="text-decoration: line-through;">' . $truck[0]['truck_cost'] . ' &euro;</span> <span style="color:#f00;font-weight:bold;margin-left:10px">' . $truck[0]['truck_special-offer-price'] . ' &euro;</span>': $truck[0]['truck_cost'] . " &euro;")); echo $language['truck-details_cost-VAT'];?></td>
            </tr>
            <tr><td><?php print($language['truck-details_short-comment']); ?>:</td>
                <td><?php print(nl2br($truck[0]['truck_short-comment'])); ?></td>
            </tr>

            <tr><td><?php print($language['truck-details_description']); ?>:</td>
                <td><?php print(nl2br($truck[0]['truck_desc'])); ?></td>
            </tr>
            <!--         <tr><td colspan="1"><a href="aktualis_truckdetails_createpdf.php?truckid=<?php print($truck[0]['truck_id']); ?>&amp;lang=<?php print($lang); ?>" target="blank"><?php print($language['truck-details_print']); ?></a></td>
                         </tr>-->
						<?php
							$pdf = '/pdf/'.($truck[0]['truck_saxon-id']).'.pdf';
							if(is_file(DOCUMENT_ROOT.$pdf)) {
						?>
						<tr>
							<td>PDF:</td>
							<td><a href="<?php print($pdf); ?>" target="_blank"><?php print($truck[0]['truck_saxon-id']); ?>.pdf</a></td>
            </tr>
						<?php
							}
						?>
        </table>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <div>
            <div style="float: left; width: 20px;">&nbsp;</div>
            <div style="float: left; width: 340px; /*height: 300px;*/">
                <?php
                if ($truck['truck_default-image'] != "")
                {
                $maxfile = str_replace(".jpg", "_max.jpg", $truck['truck_default-image'] );

                print('<div id="imagediv">');
                if (is_file($maxfile))
                print('<a href="' . $maxfile . '" target="blank" ' . (($label)?('label="'.$label.'"'):('')) . ' >' .
                '<img src="../img/trucks/' . get_truck_default_image($truck[0]['truck_id']) . '" style="width: 320px;" alt="targonca '.htmlspecialchars($truck[0]['truck_type'].' '.$truck[0]['truck_make']).'" title=targonca "'.htmlspecialchars($truck[0]['truck_type'].' '.$truck[0]['truck_make']).'" />' .
                '</a></div>');
                else
                print('<img src="../img/trucks/' . get_truck_default_image($truck[0]['truck_id']) . '" style="width: 320px;" alt="targonca '.htmlspecialchars($truck[0]['truck_type'].' '.$truck[0]['truck_make']).'" title=targonca "'.htmlspecialchars($truck[0]['truck_type'].' '.$truck[0]['truck_make']).'" /></div>');

                foreach ($truck[0]['images'] as $key => $img)
                if (is_file('../img/trucks/' . $img))
                {
                	$label = $truck[0]['labels'][$key];
                $maxfile = '../img/trucks/' . str_replace(".jpg", "_max.jpg", $img);
                if (is_file($maxfile))
                $max = $maxfile;
                else
                $max = "none";  //ezt v�rja a js ha nem kell link a max-ra

                print('<a href="#" style="border:none" onclick="setimagenew(\'' . $img . '\', \'' . $max . '\', \'' . $label . '\');" label="' . $label . '"><img src="../img/trucks/' . $img . '" style="width: 80px; margin-top:10px; margin-left:10px; border:none"  alt="targonca '.htmlspecialchars($truck[0]['truck_type'].' '.$truck[0]['truck_make']).'" title="targonca '.htmlspecialchars($truck[0]['truck_type'].' '.$truck[0]['truck_make']).'" /></a>');
                }
                //<a href=\"#\" onclick=\"setimage(" . ($imageid - 1) . ", " . $truckid . ");\">" . $language['truck-details_prev-image'] . "</a>
                }

                //        $imageidoverride = $truck[0]['truck_default-image'];
                //        include("aktualis_ajax_getimagesdiv.php");
                ?>
                <br style="clear:both;"/>
            </div>

        </div>
    </body>
</html>