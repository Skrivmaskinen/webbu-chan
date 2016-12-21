<?php

// Connect database
$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
//No connection -> exit code with error message
if(!$connection){
	die("<h3>Failed to connect to database</h3>");
}
$search = mysqli_real_escape_string($connection, $_GET['ID']);
// Search for an approximate partname 
$result = mysqli_query($connection, "
		SELECT 
			Partname, PartID, ItemtypeID, inventory.ColorID
		FROM 
			parts, inventory, colors

		WHERE 
				parts.PartID=inventory.ItemID
			AND
				PartID = '$search'
			AND
				inventory.ColorID = colors.ColorID
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
$itemtype_id = $row['ItemtypeID'];
 
$part_name = $row['Partname'];
$part_id = $row['PartID']; 
$color_id = $row['ColorID'];
 
$imagesearch = mysqli_query($connection, 
			"SELECT * 
			FROM images 
			WHERE 
				ItemTypeID='$itemtype_id' 
			AND 
				ItemID='$part_id' 
			AND 
				ColorID='$color_id'");
$imageInfo = mysqli_fetch_array($imagesearch);

$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";

$imagePath;

if($imageInfo['has_largejpg']) 
{ 
	// Use JPG if it exists
	$filename = "$itemtype_id"."L/$part_id.jpg";
	$imagePath = $prefix.$filename;
} 
else if($imageInfo['has_largegif'] ) 
{ 
	// Use GIF if JPG is unavailable
	$filename = "$itemtype_id"."L/$part_id.gif";
	$imagePath = $prefix.$filename;
}
else if($imageInfo['has_gif'] ) 
{ 
	// Use GIF if JPG is unavailable
	$filename = "$itemtype_id/$color_id/$part_id.gif";
	$imagePath = $prefix.$filename;
}
else if($imageInfo['has_gif'] ) 
{ 
	// Use GIF if JPG is unavailable
	$filename = "$itemtype_id/$color_id/$part_id.gif";
	$imagePath = $prefix.$filename;
}
else 
{ 
	// If neither format is available, insert a placeholder image
	$filename = "noimage.png";
	$imagePath = $filename;
}

//Print info
print(" <h1>$part_name</h1>
		<img id=\"focus_image\" src=\"$imagePath\" onclick=\"modalImage()\" alt=\"Image of $part_name\">
		<div id=\"the_modal\" class=\"modal\">
			<span id=\"close\">&times;</span>
			<img class=\"modal_content\" id=\"img01\" alt=\"Image of $set_name\"> 
		</div>
		<p><span>ItemID:</span> $part_id</p>
		<p><span>ItemType:</span> $itemtype_id</p>
		<h3>Colors:</h3>
		<div id='colors'>
		");

include("part_show_colors.php");
print("</div>");

?>
