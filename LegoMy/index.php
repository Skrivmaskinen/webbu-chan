<!doctype html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<link href="style.css" media="screen" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee" rel="stylesheet">
		<title>Lego Search</title>
	</head>
	
	<body>
		
		<div id="header">
			Lego Search Engine
		</div>
		
		<div id="whitener">
			<div id="text"> 
			Search for ...
			</div>
			
			<div id="wrapper">
				<form>
					<!--part-->
					
					<input id="part_form" type="radio" name="search_type" value = "Part" checked>
					<label id="part_form_visual" class="button" for="part_form">Part</label>
					<input id="set_form" type="radio" name="search_type" value = "Set">
					<label id="set_form_visual" class="button" for="set_form">Set</label>
					<br>
					<div id="search_container">
						<input id="search_bar" type="text" placeholder="search lego" name="search_key" >
						<input id="submit_button" type="submit" value="search">
					</div>
				</form>
				
				<?php
					$search_type = $_GET['search_type'];
				
					if($search_type == 'Part'){
						
						include "part_search.php";
						
						
					}else if($search_type == 'Set'){
						
						include "set_search.php";
						
						
					}else{
						
						
					}
					
				
				?>
				
			</div>
		</div>
		
		
	</body>


</html>