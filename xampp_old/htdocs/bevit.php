
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bevit.php</title>  
</head>  

<script>
function betuselect(p1){
  var x = document.getElementById("ispart_combo").options[p1.value].getAttribute("betu");
  res = x.split(',');
  document.myform.betucombo.options.length=0;
  for (i=0; i<res.length; i++){
    document.myform.betucombo.options[i]=new Option(res[i]);
  }
}
</script>

<form name="myform" method="post">
  <div style="width:500px; height:100px; 	border: 1px solid #000000; padding: 10px;">
    <div>Kategóriák: 
        <select style="width:226px;" size="1" id="ispart_combo" name="ispart" onchange="betuselect(this)">
          <option value="0"  betu="H,S,V" >Villás targoncák</option>
          <option value="1"  betu="W,X,Y,T,E" >Fődarabok</option>
          <option value="2"  betu="H,S,V" >Építő gépek</option>
          <option value="3"  betu="R" >Kézi emelők</option>
          <option value="4"  betu="A" >Adapterek</option>
          <option value="5"  betu="H,S,V" >Vontatók, golfautók</option>
          <option value="6"  betu="K" >Kiegészítők</option>
          <option value="7"  betu="S" >Sehová</option>
          <option value="8"  betu="M" >Emelőszerkezetek, villák</option>
          <option value="9"  betu="G" >Gumiköpenyek, felnik</option>
        
  
        </select>
    </div>
    ----------------------------------------------------
    <div>Betűjelek: 
        <select style="width:50px;" size="1" id="betu_combo" name="betucombo" >
          <option value="0">-</option>
        </select>
    </div>
  </div>
</form>

<?php

echo ''; 

?>

</html>

