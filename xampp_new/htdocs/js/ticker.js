function step()
{
  var top = document.getElementById("upTextScroll");
 
  if(top)
  {
    var left = top.style.left.substr(0,top.style.left.indexOf("p"));
    var width = top.style.width.substr(0,top.style.width.indexOf("p"));
    width = (-1)*(width) - 3;
    if(left > width + 3)
    {
      top.style.left = left-5 + "px";
    }
    else
    {
      top.style.left = "920px";
    }
  }
  
  setTimeout("step()",100);
}

step();