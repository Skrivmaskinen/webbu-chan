<!doctype html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<link href="style.css" media="screen" rel="stylesheet">
		<title>Lego Search</title>	
	</head>
	
	<body>
		<div id="wrapper">
			<form action="action_page.php">
				part
				<input id="part_form" type="radio" name="search_type" value = "Part" checked>
				set
				<input type="radio" name="search_type" value = "Set">
				<input id="search_bar" type="text" 	name="search_key">
				<input id="submit_button" type="submit" value="search">
			</form>
		</div>
	</body>


</html>