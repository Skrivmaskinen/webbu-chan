<?php

$search = trim($_GET['search']);
if(strlen($search)>=3)
{
//Maximum number of results.
$limit = 20;
//add 1 for checking if there are more results than $limit 
$limit++;

//Initialize start_index to 0. (In case there is none in URL)
$start_index = 0;

//If there exist a start index in the URL, change start_index to that.
if(isset($_GET['start_index']))
{
	$start_index = $_GET['start_index'];
}
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
	Offset
		$start_index 
	");
//set limits to original state
$limit--;
//Link to next page
$change_page_url = "?";

//Add search to link.
if(isset($_GET['search'])) 
{
	$change_page_url = $change_page_url."search=".$_GET['search'];
}

//Intitialize the start index of next page and previous page.
$start_index_next = $limit;
$start_index_prev = 0;

//Change start_index_next and start_index_prev to be values relative to the current start_index.
if(isset($_GET['start_index'])) 
{
	$start_index_next = $_GET['start_index'] + $limit;
	
	//Change start_index_prev only if the start index will lead to results. (i.e. no negative start_index)
	if($_GET['start_index'] >= $limit)
	{
		$start_index_prev = $_GET['start_index'] - $limit;
	}
	
}

//"URL" to the next and previous page.
$prev_page = $change_page_url."&start_index=".$start_index_prev;
$next_page = $change_page_url."&start_index=".$start_index_next;		

//Number of results
$number_of_results = mysqli_num_rows($result);
// Print results
print("<table>
		<tr>
			<th>Part ID</th>
			<th>Part name</th>
			<th>Quantity</th>
			<th>Part picture</th>
			
		</tr>
	");

$count = 0;
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
	
	if($count++ < $limit){
		//Write table
		print("<tr>
				<td>$part_id</td>
				<td><a href='part_page.php?search=$part_id'>$part_name</a></td>
				<td> $quantity </td>
				<td> <img src=\"$imagePath\" alt=\"lego part $part_name\"> </td>
			   </tr>
				");
	}
	
} // end while

print("</table>");
//include buttons for page change buttons
include ("prev_next_buttons.php");
} else{print("<h3>Your search needs to contain least 3 characters.</h3>");}
?>
