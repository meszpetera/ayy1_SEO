<div id="dShowBox">
  <div style="width:130px;margin:5px;font-size:10px;">
    <p style="font-weight:bold;">{$finished}</p>
    <p>{$zoom}</p>
  </div>
  <div style="width:140px;height:90px;position:absolute;right:10px;top:3px;font-size:10px;vertical-align:middle;">
    <a href="{$imagelink}" class="highslide" onclick="return hs.expand(this);" id="promo_link">
      <img alt="" src="{$defaultpic}" style="width:140px;height:90px;" id="promo_image" />
    </a>
    <input type="hidden" value="{$defaultid}" id="promo_id" />
  </div>
</div>

<script type="text/javascript">setTimeout("change_to_next()", speed);</script>

<br />
<a href="/parts" style="color:#fff;"><h1><img src="/img/pdf.png" style="width:24px" alt="" />Árajánlat kérés</h1></a>

<div>
    {$content}
</div>

