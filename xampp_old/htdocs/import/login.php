    <!DOCTYPE html>
    <html>
    <head>
		<meta charset=utf-8 />
		<title>Saxon import bejelentkezés</title>
    </head>
    <body>
		<h1>Saxon import</h1>
		<h2>Bejelentkezés</h2>
		<form method="post" action="import.php">
			<table>
				<tr>
					<td><label for="name">Név:</label></td>
					<td><input type="text" id="name" name="name"></td>
				</tr>
				<tr>
					<td><label for="pwd">Jelszó:</label></td>
					<td><input type="password" id="pwd" name="pwd"></td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<input type="submit" value="Bejelentkezés">
					</td>
				</tr>
			</table>
			<input type="hidden" name="action" value="login">
		</form>
    </body>
    </html>