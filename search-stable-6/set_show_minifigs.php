<?php
//Maximum number of results.
$limit = 20;
//add 1 for checking if there are more results than $limit 
$limit++;

//Initialize start_index to 0. (In case there is none in URL)
$start_index = 0;

//If there exist a start index in the URL, change start_index to that.
if(isset($_GET['start_index']))
{
	$start_index = mysqli_real_escape_string($connection, $_GET['start_index']);
}
// Search on part name
$result = mysqli_query($connection, "
	SELECT 
		Minifigname, MinifigID, ItemtypeID, inventory.Quantity
	FROM 
		minifigs, inventory
	
	WHERE 
			minifigs.MinifigID=inventory.ItemID
		AND
			SetID = '$search'
	GROUP BY
		Minifigname
	ORDER BY
		Minifigname
	LIMIT 
		$limit
	Offset
		$start_index 
	");

//Number of results
$number_of_results = mysqli_num_rows($result);
// If there are no matches to search, don't print any results
if($number_of_results == 0){
	 mysqli_close($connection);
	die("<h3>This set contains no minifigs</h3>");
}
	
$count_search = mysqli_query($connection, "
		SELECT 
			count(DISTINCT Minifigname) as count
		FROM 
			minifigs, inventory
		WHERE 
			minifigs.MinifigID=inventory.ItemID
		AND
			SetID = '$search'
		");
$count_row = mysqli_fetch_array($count_search)['count'];
print("<h3>This set contains the following $count_row minifigs:</h3>");


//set limits to original state
$limit--;
//Link to next page
$change_page_url = "?";

//Add search to link.
if(isset($_GET['ID'])) 
{
	$change_page_url = $change_page_url."ID=".$search;
}

//Intitialize the start index of next page and previous page.
$start_index_next = $limit;
$start_index_prev = 0;

//Change start_index_next and start_index_prev to be values relative to the current start_index.
if(isset($_GET['start_index'])) 
{
	$start_index_next = $start_index + $limit;
	
	//Change start_index_prev only if the start index will lead to results. (i.e. no negative start_index)
	if($_GET['start_index'] >= $limit)
	{
		$start_index_prev = $start_index - $limit;
	}
	
}

//"URL" to the next and previous page.
$prev_page = $change_page_url."&start_index=".$start_index_prev."&showtype=M";
$next_page = $change_page_url."&start_index=".$start_index_next."&showtype=M";		


// Print results
print("<table>
		<tr>
			<th>Minifig ID</th>
			<th>Minifig name</th>
			<th>Quantity</th>
			<th>Minifig picture</th>
			
		</tr>
	");

$count = 0;
while ($row = mysqli_fetch_array($result)) {						  
	//Set variables
	$itemtype_id = $row['ItemtypeID'];
	 
	$minifig_name = $row['Minifigname'];
	$minifig_id = $row['MinifigID']; 
	$quantity = $row['Quantity'];
	
	//Conncet to database to get images
	$imagesearch = mysqli_query($connection, 
				"SELECT * 
				FROM images 
				WHERE 
					ItemTypeID='$itemtype_id' 
				AND 
					ItemID='$minifig_id' 
				AND 
					ColorID='$color_id'");
					
	$imageInfo = mysqli_fetch_array($imagesearch);
	
	$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
	
	$imagePath;
	
	//Get small images 
	if($imageInfo['has_jpg']) 
	{ 
		// Use JPG if it exists
		$filename = "$itemtype_id/$minifig_id.jpg";
		$imagePath = $prefix.$filename;
	} 
	else if($imageInfo['has_gif'] ) 
	{ 
		// Use GIF if JPG is unavailable
		$filename = "$itemtype_id/$minifig_id.gif";
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
				<td>$minifig_id</td>
				<td>$minifig_name</a></td>
				<td> $quantity </td>
				<td> <img src=\"$imagePath\" alt=\"Image of $minifig_name\"> </td>
			   </tr>
				");
	}
	
} // end while

print("</table>");
//include buttons for page change buttons
include ("prev_next_buttons.php");
 mysqli_close($connection);
?>
