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
<a href="/sys/handling_equipment_create_excel_sheet.php?lang=eng" style="color:#fff;"><h1><img src="/img/excel.png" alt="" /> Our current stock</h1></a>
<a href="/?page=root_trucks&lang=eng" style="color:#fff;"><h1><img src="/img/pdf.png" style="width:24px" alt="" />Request an offer</h1></a>
<a href="/?page=climax&lang=eng" style="color:#fff;"><h1><img src="/img/pdf.png" style="width:24px" alt="" /> Climax catalog</h1></a>
<a href="/?page=tvh&lang=hun" style="color:#fff;"><h1><img src="/img/pdf.png" style="width:24px" alt="" /> TVH Handling catalog</h1></a>

<!--p style="font-size: 32px; padding: 0 0 0 0; margin: 0 0 0 0">TRUCKS AND PALLET LIFTERS</p-->
<br />
<br />
<div>
    {$content}
    <div>