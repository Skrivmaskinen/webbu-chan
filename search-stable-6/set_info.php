<?php

$limit = 20;
 // Connect to database
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 $search =  mysqli_real_escape_string($connection, $_GET['ID']);

 // Search set name
 $result = mysqli_query($connection, "
		SELECT 
			*
		FROM 
			sets, categories
		WHERE
			sets.CatID = categories.CatID
		AND
			SetID = '$search'
		LIMIT 
			1
		");
// If ID is is invalid, don't print any more info
$number_of_results = mysqli_num_rows($result);
if($number_of_results == 0){
	 mysqli_close($connection);
	die("<h3>This item does not exist</h3>");
}

$row = mysqli_fetch_array($result);						  
//Set variables
$set_name = $row['Setname'];
$set_id = $row['SetID'];
$year = $row['Year'];
$category = $row['Categoryname'];

//Get image for set
$imagesearch = mysqli_query($connection, 
		"SELECT * 
		FROM images 
		WHERE 							
			ItemID='$set_id' ");

$imageInfo = mysqli_fetch_array($imagesearch);

$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";

$imagePath;

//Get images for table
if($imageInfo['has_largejpg']) 
{ 
	// Use JPG if it exists
	$filename = "SL/$set_id.jpg";
	$imagePath = $prefix.$filename;
} 
else if($imageInfo['has_largegif']) 
{ 
	// Use GIF if JPG is unavailable
	$filename = "SL/$set_id.gif";
	$imagePath = $prefix.$filename;
}
else if($imageInfo['has_gif'])
{
	// Use JPG if it exists
	$filename = "S/$set_id.gif";
	$imagePath = $prefix.$filename;
}
else if($imageInfo['has_jpg'])
{
	// Use JPG if it exists
	$filename = "S/$set_id.jpg";
	$imagePath = $prefix.$filename;
}
else 
{ 
	// If neither format is available, insert a placeholder image
	$filename = "noimage.png";
	$imagePath = $filename;
}

//Print info
print(" <h1>$set_name</h1>
	<img id=\"focus_image\" src=\"$imagePath\" alt=\"Image of $set_name\">
	<div id=\"the_modal\" class=\"modal\">
			<span id=\"close\">&times;</span>
			<img class=\"modal_content\" id=\"img01\"> 
	</div>
	<p><span>SetID:</span> $set_id</p>
	<p><span>Year:</span> $year</p>
	<p><span>Category:</span> $category</p>");
 
?>
