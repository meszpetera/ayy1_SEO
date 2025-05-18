function printHTML(page,x,y) {
	if(x) { document.getElementById("printf").style.width=x; }
	if(y) { document.getElementById("printf").style.height=y; }
	var newWin = window.frames["printf"];
			newWin.document.write(`<body onload="window.print()">${page}</body>`);
			newWin.document.close();
}

function printLocationQR(name,depot,subdepot,code) {
	var page = `<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />`;
	page += `
		<style>
			@page {
					size: 88mm 35mm;
					margin: 0mm 0mm 0mm 0mm;
				}
				html, body { width: 100%; height: auto; overflow: hidden; font-size: 2vw; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; white-space:nowrap; margin: 0px; background-color: #FFF; }
				h1 { text-align: center; font-family: Arial, Helvetica, sans-serif; width: 52mm; display: inline-block; vertical-align: top; font-size: 9mm; line-height: 18mm; margin: 0px; position: relative; top: 2mm; left: 1mm; }
				h1 > small { position: absolute; top: 15mm; display: block; line-height: 1.3em; text-align: center; font-size: 4mm; white-space: break-spaces; max-width: 52mm; }
				h1 > small > br { display: none; }
				img.qr { max-width: 32mm; height: 31mm; display: inline-block; vertical-align: bottom; margin: 2mm; max-width: 52mm; }
		</style>`;
	page += `<h1>${code}<small>${name}</small></h1>`;
	page += `<img src='/newqr/?text=`+ encodeURIComponent(`{"type":"location","depot":"${depot}","subdepot":"${subdepot}","code":"${code}"}`) +`' class="qr">`;
	printHTML(page,'88mm','35mm');
}

function printTruckQR(SaxonID,data) {
	var $this = jQuery(`div.truck-${SaxonID}`);
	var image = jQuery(`a.highslide`,$this).attr(`href`);
	var page = `<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />`;
	page += `
		<style>
		@page {
				size: 88mm 35mm;
				margin: 0mm 0mm 0mm 0mm;
			}
			html, body { width: 100%; height: auto; overflow: hidden; font-size: 2vw; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; white-space:nowrap; margin: 0px; background-color: #FFF; }
			h1 { text-align: right; font-family: Arial, Helvetica, sans-serif; width: 52mm; display: inline-block; vertical-align: top; font-size: 15mm; line-height: 34mm; margin: 0px; position: relative; top: 2mm; left: 3mm; }
			img.qr { max-width: 32mm; height: 31mm; display: inline-block; vertical-align: bottom; margin: 2mm; }
		</style>`;
	page += `
		<h1>${SaxonID}</h1>
		<img src='/newqr/?text=`+ encodeURIComponent(`http://saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=hun&id=${data.truck_id}#${SaxonID}`) +`' class="qr" />
	`;

	printHTML(page,'88mm','35mm');
}