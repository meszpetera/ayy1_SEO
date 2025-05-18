<?php $_title = ('Targonca, személyemelő, vontató, golfkocsi'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Targonca és egyéb emelő, vontató gépek, golfkocsi bérbeadása, javítása, eladása.</title>
<meta name="keywords" content="targonca, személyemelő, vontató, golfkocsi, targonca adapterek, gumiköpenyek, akkumulátorok, raklapemelők" />

<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/styles_aktualis.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/image_preload.js?<?php print((is_file('./js/image_preload.js'))?(filemtime('./js/image_preload.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/promo.js?<?php print((is_file('./js/promo.js'))?(filemtime('./js/promo.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/ticker.js?<?php print((is_file('./js/ticker.js'))?(filemtime('./js/ticker.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/framework/prototype.js"></script>
<script type="text/javascript" src="js/framework/scriptaculous.js"></script>
<script type="text/javascript" src="js/ajax_tools.js?<?php print((is_file('./js/ajax_tools.js'))?(filemtime('./js/ajax_tools.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/aktualis.js?<?php print((is_file('./js/aktualis.js'))?(filemtime('./js/aktualis.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/aktualis_truckdetails.js?<?php print((is_file('./js/aktualis_truckdetails.js'))?(filemtime('./js/aktualis_truckdetails.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/offerrequest.js?<?php print((is_file('./js/offerrequest.js'))?(filemtime('./js/offerrequest.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/flyer.js?<?php print((is_file('./js/flyer.js'))?(filemtime('./js/flyer.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/ibox/ibox.js"></script>
<script type="text/javascript" src="js/offer_send.js?<?php print((is_file('./js/offer_send.js'))?(filemtime('./js/offer_send.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/users.js?<?php print((is_file('./js/users.js'))?(filemtime('./js/users.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/highslide/highslide.js"></script>
<script type="text/javascript" src="js/registration.js?<?php print((is_file('./js/registration.js'))?(filemtime('./js/registration.js')):(date('Ymd'))); ?>"></script>
<script type="text/javascript" src="js/datetimepicker.js"></script>
<script type="text/javascript" src="js/prototype.maskedinput.js"></script>
<!--[if lte IE 6]>
<script type="text/javascript" src="js/scrolling.js"></script>
<link href="css/styles_ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen"/>
<link href="css/styles_offersummary.css?<?php print((is_file('./css/styles_offersummary.css'))?(filemtime('./css/styles_offersummary.css')):(date('Ymd'))); ?>" rel="stylesheet" type="text/css" />
<link href="css/styles_login.css?<?php print((is_file('./css/styles_login.css'))?(filemtime('./css/styles_login.css')):(date('Ymd'))); ?>" rel="stylesheet" type="text/css" />
<link href="css/styles_offeredit.css?<?php print((is_file('./css/styles_offeredit.css'))?(filemtime('./css/styles_offeredit.css')):(date('Ymd'))); ?>" rel="stylesheet" type="text/css" />
<link href="css/highslide.css" rel="stylesheet" type="text/css" />
<link href="css/styles_reg.css?<?php print((is_file('./css/styles_reg.css'))?(filemtime('./css/styles_reg.css')):(date('Ymd'))); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  var loggedin = "<?php echo loggedin() ? 1 : 0; ?>";
  var language = "<?php echo $lang ?>";
  check_login();
  hs.graphicsDir = 'img/hs_imgs/';
  hs.outlineType = 'rounded-green';
  hs.showCredits = false;
  hs.dimmingDuration = 200;
  hs.dimmingOpacity = 0.75;
  hs.registerOverlay({
  	overlayId: 'closebutton',
  	position: 'top right',
  	fade: 2, // fading the semi-transparent overlay looks bad in IE
    useOnHtml: true
  });
  hs.cacheAjax = false;


  hs.Expander.prototype.onBeforeExpand = function (sender)
  {
    if (!(sender.custom === undefined))
    {
      if (!(sender.custom.onExpand === undefined))
      {
        try
        {
          sender.custom.onExpand();
        }
        catch (error)
        {
          alert("Script execution failed.\nThe given error message is the following: \"" + error + "\"\n\nThe failed script is listed below:\n" + sender.custom.onExpand);
        }
      }
    }
    return true;
  }

  hs.Expander.prototype.onAfterClose = function (sender)
  {
    if (!(sender.custom === undefined))
    {
      if (!(sender.custom.onClosed === undefined))
      {
        try
        {
          sender.custom.onClosed();
        }
        catch (error)
        {
          alert("Script execution failed.\nThe given error message is the following: \"" + error + "\"\n\nThe failed script is listed below:\n" + sender.custom.onClose);
        }
      }
    }
    return true;
  }


</script>
<?php
    if ($active_page == 'elerhetoseg')
    {
        if ($lang == 'hun')
            $gmaps_lang = 'hu';
        else
            $gmaps_lang = 'en';

        echo '<script src="https://maps.google.com/maps?file=api&v=2&key=ABQIAAAAXBjca3QqxzHEG_ViOmPGwhTQbya5zm9oovnmQvAPDX78VPRSQxRno8SG5dqmDD3_0spKoF5XlAvW2w&sensor=false&hl=' . $gmaps_lang . '" type="text/javascript"></script>';
    }
    else if ($active_page == 'siteFront' || $active_page == 'rolunk')
    {
        echo '<script type="text/javascript">
        var moments_index = 0;
        function start_moments()
        {
            setTimeout("m_fadeout()", 2000);
        }

        function m_fadeout()
        {
            Effect.Fade($(\'moments\').getElementsByTagName(\'img\')[moments_index].id, { duration: 1.0, afterFinish: function(){m_step();} });
        }

        function m_step()
        {
            //moments_index++;

            //if (moments_index == $(\'moments\').getElementsByTagName(\'img\').length)
            //    moments_index = 0;

            moments_index = Math.floor(Math.random()*$(\'moments\').getElementsByTagName(\'img\').length);

            Effect.Appear($(\'moments\').getElementsByTagName(\'img\')[moments_index].id, { duration: 1.0, afterFinish: function(){setTimeout("m_fadeout()", 2000);} });
        }
        </script>';
			if($active_page == 'rolunk') {
        echo '<script type="text/javascript">
        var moments2_index = 1;
        function start_moments2() {
					setTimeout(function() {
						jQuery("#moments2 img#lol"+(moments2_index)).fadeToggle( 1000, "linear", function() { m2_step(); });
					}, 2000);
        }
        function m2_step() {
					var moments2_index = Math.floor(Math.random()*jQuery("#moments2 img").length);
					jQuery("#moments2 img#lol"+(moments2_index)).fadeToggle( 1000, "linear", function() {
						setTimeout(function() {
							jQuery("#moments2 img#lol"+(moments2_index)).fadeToggle( 1000, "linear", function() { m2_step(); });
						}, 2000);
					});
        }
        </script>';
			}
    }
?>

<script language="javascript" type="text/javascript">AC_FL_RunContent = 0;</script>
<script src="js/AC_RunActiveContent.js" language="javascript" type="text/javascript"></script>
<?php echo $CFG['trackingsnippet']; ?>
<?php
	if(is_mobile()) {
		print('<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=6.0, user-scalable=1" />');
	}
?>
</head>
<body onload="process_bottom_textscroll();<?php echo $body_onload_functions ?>">
<div id="closebutton" class="highslide-overlay closebutton" onclick="return hs.close(this)" title="<?php echo $language['close']; ?>"></div>
<div class="dMain">
  <div class="dContainer" id="MainContainer">
    <div class="dHeader_<?php echo $lang ?>">
		<a href="https://<?php print($_SERVER['HTTP_HOST']); ?>" class="logo"></a>

	   
<!-- <div style="position:absolute;top:55px;left:30px;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;color:#e5b802;"><?php echo $beta; ?></div>-->


		<div class="dUserBox" id="UserBox" style="width:320px;height:18px;top:18px;right:20px;">
			<div class="dUserInfo">
				<?php echo $user_box_top; ?>
			</div>
		</div>
		<div class="dUserBox" id="UserBox" style="width:310px;height:28px;top:39px;right:10px;">
			<div class="dUserInfo">
				<?php echo
				   '<a href="?page=' . $_REQUEST['page'] . '&lang=hun"><img src="https://'.($_SERVER['HTTP_HOST']).'/img/flags/hu.png" alt="Váltás magyar nyelvre" style="border-width: 0px"/></a>&nbsp;'.
				   '<a href="?page=' . $_REQUEST['page'] . '&lang=eng"><img src="https://'.($_SERVER['HTTP_HOST']).'/img/flags/gb.png" alt="Switch to english" style="border-width: 0px"/></a>';
				?>
				<div class="top_keres">
				<form action="?lang=<?php echo $lang; ?>&page=aktualis" method="post" class="TopSearch" >
					<input type="text" name="saxonsearch" id="saxonsearchtop" placeholder="<?php print($language['search_placeholder']) ?>" value="<?php echo $_REQUEST['saxonsearch'] ?>" class="TopSearchInput" style="border:2px solid #FFFFFF;width:150px;" />
					<script type="text/javascript">
						Event.observe(window, 'load', function() {
							new MaskedInput('#saxonsearchtop', 'a-9999?');
						});
					</script>
					<input type="submit" value="<?php print($language['search_btn']) ?>" class="TopSearchSubmit"/>
				</form>
				</div>
			</div>
		</div>
		<div id="whyregister" class="dHelp"><?php echo $language['userman_whyregistertext']; ?>
		</div>
      <div class="dMenu">
        <?php echo $main_menu; ?>
      </div>
    </div>
    <div class="dBlackStrip"><!-- --></div>
    <!--div class="dTextScroll" id="upTextScrollParent">
      <div style="width:<?php echo $top_width; ?>px;height:17px;position:relative;top:0px;left:920px;" id="upTextScroll">
        <?php echo $top_scroll; ?>
      </div>
    </div-->
<style>
	.upTextScrollParent { display:block;position:relative;width:100%;max-width:100%; }
	.upTextScroll { display:block;position:relative;width:100%;max-width:100%;height:20px;overflow:hidden;background-color:#FF0; }
	.upTextScrollRow { display:block;position:absolute;top:0px;left:100%;width:100%;max-width:100%;overflow:hidden;text-align:center;font-family: arial;line-height:20px; }
</style>
<div class="upTextScrollParent">
	<div class="upTextScroll">
		<div class="upTextScrollRow"><?php echo join('</div><div class="upTextScrollRow">',$top_scroll); ?></div>
	</div>
</div>
		<script type="text/javascript">
			function upTextCcrolling() {
				if(jQuery('.upTextScroll').attr('stop')=='false') {
					var akt = jQuery(".upTextScroll>div.aktive");
					var next = jQuery(akt).next();
					if(!(next).hasClass('upTextScrollRow')) {
						var next = jQuery(".upTextScroll>div:first");
					}
					jQuery(akt).animate(
						{left: "-100%"},800,
						function() {
							jQuery(this).removeClass('aktive');
							jQuery(this).delay(500).css({left: "100%"});
						}
					);
					jQuery(next).animate(
						{left: "0%"},1000,
						function() { jQuery(this).addClass('aktive'); }
					);
				}
				setTimeout(function(){upTextCcrolling()},5000);
			}
			jQuery(document).ready(function() {
				jQuery('.upTextScroll').attr('stop','false');
				jQuery('.upTextScroll').hover(function(){jQuery(this).attr('stop','true');},function(){jQuery(this).attr('stop','false');});
				if(jQuery('.upTextScrollRow',jQuery('.upTextScroll')).length==1) {
					jQuery('.upTextScroll').append(jQuery('.upTextScroll').html());
					jQuery('.upTextScroll>div:last').addClass('aktive');
					jQuery('.upTextScroll>div:last').css({left: "-100%"});
				}
				upTextCcrolling();
			});
		</script>
    <div class="dDecorationUp"> </div>
    <div class="dData" id="data">
      <?php echo $main_content; ?>
    </div>
    <div class="dTextScrollBottom" id="dTextScrollBottom">
				<div style="position:absolute;right:-65px;top:-5px;"> <?php echo $user_box_bottom; ?> </div>
				<a href="/qr/?text=<?php print(urlencode('https://'.($_SERVER['HTTP_HOST']).($_SERVER['REQUEST_URI']).'')); ?>" class="highslide" onclick="return hs.expand(this,{'align':'center'});" target="_blank" style="float:left;"><img src="/qr/?text=<?php print(urlencode('https://'.($_SERVER['HTTP_HOST']).($_SERVER['REQUEST_URI']).'')); ?>" height="60" border="0" /></a>
				<a href="https://plusone.google.com/_/+1/confirm?hl=hu&url=<?php print(urlencode('https://'.($_SERVER['HTTP_HOST']).($_SERVER['REQUEST_URI']).'')); ?>&title=<?php print(urlencode($_title)); ?>" target="_blank" onclick="window.open(this.href, '_blank', 'status=0, height=300, width=550, resizable=0' ); return false;" style="float:left;margin-left:10px;"><img src="/pic/google.png" alt="" height="60" border="0" /></a>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php print(urlencode('https://'.($_SERVER['HTTP_HOST']).($_SERVER['REQUEST_URI']).'')); ?>&t=<?php print(urlencode($_title)); ?>" target="_blank" onclick="window.open(this.href, '_blank', 'status=0, height=400, width=360, resizable=0' ); return false;" style="float:left;margin-left:10px;"><img src="/pic/facebook.png" alt="" height="60" border="0" /></a>
				<a href="https://twitter.com/intent/tweet?url=<?php print(urlencode('https://'.($_SERVER['HTTP_HOST']).($_SERVER['REQUEST_URI']).'')); ?>&text=<?php print(urlencode($_title)); ?>" target="_blank" onclick="window.open(this.href, '_blank', 'status=0, height=550, width=360, resizable=0' ); return false;" style="float:left;margin-left:10px;"><img src="/pic/twitter.png" alt="" height="60" border="0" /></a>
        Partnereink:
        <a href="http://www.mascus.hu/Anyagmozgatas/Hasznalt-Targoncak" target="_blank" title="használt targoncák">Használt targoncák</a> |
        <a href="http://www.topapro.hu/aprohirdetesek/epitoanyag-gep-szerszam/targonca/?oldal=1" target="_blank" title="Targonca hirdetések">Targonca hirdetések</a>
    </div>
  </div>
	<style>
		#szechenyi::before {
			content: '';
			display: block;
			position: fixed;
			bottom: 0px; left: 0px;
			width: 240px; height: 10px;
			z-index: 9;
		}
		#szechenyi {
	    display: block;
	    position: fixed;
	    left: 0px;
	    bottom: <?php print((isSet($_COOKIE['szechenyiHidden']))?('-190px'):('0px')); ?>;
	    z-index: 10;
	    width: 260px;
	    height: 195px;
	    z-index: 999;
	    background-image: url(/pic/szechenyi.png);
	    background-repeat: no-repeat;
	    background-position: 50% 100%;
	    background-size: cover;
	    transition: all 300ms ease-in-out;
		}
		#szechenyi>.content>a {
	    display: block;
	    position: absolute;
	    width: 230px;
	    height: 175px;
	    top: 20px;
	    left: 0px;
		}
		#szechenyi:hover {
	    bottom: 0px;
		}

		:root {
			--closeColor: #F4A259;
			--closeColorHover: #F25C66;
			--closeSize: 24px;
		}

		#szechenyi .close-container {
			display: <?php print((isSet($_COOKIE['szechenyiHidden']))?('none'):('block')); ?>;
			position: absolute;
			top: 0px; right: 0px;
			width: var(--closeSize); height: var(--closeSize);
			cursor: pointer;
		}

		.close-container .leftright{
			height: 4px;
			width: var(--closeSize);
			position: absolute;
			margin-top: calc(var(--closeSize)/2);
			background-color: var(--closeColor);
			border-radius: 2px;
			transform: rotate(45deg);
			transition: all .3s ease-in;
		}

		.close-container .rightleft{
			height: 4px;
			width: var(--closeSize);
			position: absolute;
			margin-top: calc(var(--closeSize)/2);
			background-color: var(--closeColor);
			border-radius: 2px;
			transform: rotate(-45deg);
			transition: all .3s ease-in;
		}

		.close-container label{
			color: white;
			font-family: Helvetica, Arial, sans-serif; 
			font-size: calc(var(--closeSize)/6);
			text-transform: uppercase;
			letter-spacing: 2px;
			transition: all .3s ease-in;
			opacity: 0;
		}
		.close-container .close{
			margin: calc(var(--closeSize)*1.2) 0 0 calc(var(--closeSize)/10);
			position: absolute;
		}

		.close-container:hover .leftright{
			transform: rotate(-45deg);
			background-color: var(--closeColorHover);
		}
		.close-container:hover .rightleft{
			transform: rotate(45deg);
			background-color: var(--closeColorHover);
		}
		.close-container:hover label{
			opacity: 1;
		}

	</style>
	<section id="szechenyi">
			<span class="close-container" onclick="szechenyiClose()">
				<span class="leftright"></span>
				<span class="rightleft"></span>
				<label class="close">close</label>
			</span>
			<section class="content">
				<a href="/vekop_1_2_6_20_2020_00740_c_fekvo_nyomdai_saxon2.pdf" target="_blank"></a>
			</section>
		</section>
</div>
<!--<div class="dTextScrollBottomContainer" id="jsTextScroll">
  <div class="dTextScrollBottom">
  </div>
</div>-->
<script type="text/javascript" src="js/aktualis_init.js"></script>
<script type="text/javascript">
	function setCookie(c_name,value,exdays) {
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null)?(""):("; expires="+exdate.toUTCString())) + ('; path=/');
		document.cookie=c_name + "=" + c_value;
	}
	function szechenyiClose() {
		document.querySelector('#szechenyi').style.bottom='-210px';
		setCookie('szechenyiHidden',1,1);
	}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-7485316-65', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
