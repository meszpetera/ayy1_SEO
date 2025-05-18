<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Saxon Rt. :: <?php echo $language['pages'][$active_page]; ?></title>

  <link href="css/highslide.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/framework/prototype.js"></script>
  <script type="text/javascript" src="js/framework/scriptaculous.js"></script>
  <script type="text/javascript" src="js/highslide/highslide.js"></script>

  <script type="text/javascript">
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
  <script type="text/javascript">
    function InvokeBlocking_Reload(url)
    {
      new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
          {
            window.location.reload();
          },
        onFailed :function()
          {
            alert("A mûvelet nem sikerült. Kérem, próbálja újból.");
          }
        });
    }  

    function InvokeBlocking_HSClose(url)
    {
      new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
          {
            hs.close(this);
          },
        onFailed :function()
          {
            alert("A mûvelet nem sikerült. Kérem, próbálja újból.");
          }
        });
    }           
  </script>
  <?php echo $CFG['trackingsnippet']; ?>
</head>
<body>
<div id="closebutton" class="highslide-overlay closebutton" onclick="return hs.close(this)" title="<?php echo $language['close']; ?>"></div>
  <?php echo $main_content; ?>
</body>
</html>