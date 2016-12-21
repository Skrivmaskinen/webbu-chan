<!doctype html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<link href="style.css" media="screen" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee" rel="stylesheet">
		<script src="script.js"></script>	
		<title>Lego Search</title>
	</head>
	
	<body>
		<header>
			<h1>
				<a href="index.php"> 
					Lego Search Engine  
				</a>
			</h1>
		</header>
		
		<div id="wrapper">
			<div id="help_info">
				<img id="help_img" src="duck.png" alt="help image">
				<p> <span>INFO!</span> <br>
					This is a lego search engine. Select <span>part</span> to search for lego parts. 
					Select <span>set</span> to search for lego sets. 
					You can search for the lego <span>name or ID</span> of the part or set in the search bar. 
					Then press the <span>search button</span>.
				</p>
			</div>
			<h2> 
				Search for ...
			</h2>
			<?php include("form.php"); ?>