<?php
	if (isset($_REQUEST['pwd']) && $_REQUEST['pwd'] == 'dealer')
		header("Location: http://saxonrt.hu/sys/trucks_create_excel_sheet.php?showprice=1");
	else 
	{
		print('<html>
		<head>
		</head>
			<body>
				<form action="http://saxonrt.hu/dealer/index.php">
					<input type="password" name="pwd" id="pwd" />
					<input type="submit" />
				</form>
			</body>
		</html>');
	}
?>