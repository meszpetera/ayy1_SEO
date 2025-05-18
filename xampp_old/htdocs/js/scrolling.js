var timerID;

function process_bottom_textscroll()
{
	var cssTextScroll = document.getElementById("cssTextScroll");
	var jsTextScroll = document.getElementById("jsTextScroll");
	cssTextScroll.style.display = "none";
	jsTextScroll.style.display = "block";
	jsTextScroll.style.position = "absolute";
	jsTextScroll.style.bottom = "0px";
	timerID  = setInterval("place_bottom_textscroll()", 40);
}

function place_bottom_textscroll()
{
	var jsTextScroll = document.getElementById("jsTextScroll");
	var data = document.getElementById("data");
	if(jsTextScroll.style.position == "absolute")
	{
		jsTextScroll.style.display = "none";	
		jsTextScroll.style.bottom = "0px";
		jsTextScroll.style.display = "block";
	}
}

function scrollingDetector()
{
	if (navigator.appName == "Microsoft Internet Explorer")
	{
		return document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
	}
	else
	{
		return window.pageYOffset;
	}
}