<?php
$search = $_GET['search'];
$limit = 50;
// Connect database
$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
// Search on part name
$result = mysqli_query($connection, "
	SELECT 
		Partname, PartID, ItemtypeID, inventory.ColorID, inventory.Quantity
	FROM 
		parts, inventory, colors
	
	WHERE 
			parts.PartID=inventory.ItemID
		AND
			SetID = '$search'
		AND
			inventory.ColorID = colors.ColorID
	GROUP BY
		Partname
	ORDER BY
		Partname
	LIMIT 
		$limit
	
	");
// Print results
print("<table>
		<tr>
			<th>Part ID</th>
			<th>Part name</th>
			<th>Quantity</th>
			<th>Part picture</th>
			
		</tr>
	");

while ($row = mysqli_fetch_array($result)) {						  
	//Set variables
	$itemtype_id = $row['ItemtypeID'];
	 
	$part_name = $row['Partname'];
	$part_id = $row['PartID']; 
	$color_id = $row['ColorID'];
	$quantity = $row['Quantity'];
	
	//Conncet to database to get images
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
	
	//Get small images 
	if($imageInfo['has_jpg']) 
	{ 
		// Use JPG if it exists
		$filename = "$itemtype_id/$color_id/$part_id.jpg";
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
	
	//Write table
	print("<tr>
			<td>$part_id</td>
			<td><a href='part_page.php?search=$part_id'>$part_name</a></td>
			<td> $quantity </td>
			<td> <img src=\"$imagePath\"> </td>
		   </tr>
			");
 
} // end while

print("</table>");
//include buttons for page change buttons
include ("prev_next_buttons.php");
?>