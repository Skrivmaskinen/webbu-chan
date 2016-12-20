<?php

$search = trim($_GET['search_key']);
if(strlen($search)>=3)
{
//Maximum number of results
$limit = 10;
//add 1 for checking if there are more results than $limit 
$limit++;
//Initialize start_index to 0. (In case there is none in URL)
$start_index = 0;

//If there exist a start index in the URL, change start_index to that.
if(isset($_GET['start_index']))
{
	$start_index = $_GET['start_index'];
}

//Connect to database.
$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
//Query to server.


//Query to server.
$result = mysqli_query($connection, "
		SELECT 
			Partname, PartID, ItemtypeID, inventory.ColorID
		FROM 
			parts, inventory, colors
		
		WHERE 
				parts.PartID=inventory.ItemID
			
			AND
				inventory.ColorID = colors.ColorID
			AND
				(Partname LIKE '%$search%'
			OR
				PartID LIKE '%$search%')
			
			
		GROUP BY
			Partname
		
		LIMIT 
			$limit
		Offset
			$start_index
		");
//set limits to original state
$limit--;	
//Number of results
$number_of_results = mysqli_num_rows($result);
// If there are no matches to search, don't print any results
if($number_of_results == 0){
	 mysqli_close($connection);
	die("<h3>Your search gave no results<h3>");
}
$count_search = mysqli_query($connection, "
		SELECT 
			count(DISTINCT PartID) as count
		FROM 
			inventory, parts
		
		WHERE 
				ItemID=PartID
			AND
				(Partname LIKE '%$search%'
			OR
				PartID LIKE '%$search%')

		");
$count_row = mysqli_fetch_array($count_search)['count'];
print("<h3>Your search gave $count_row results</h3>");

//Link to next page
$change_page_url = "?";

//Add search_type to link.
if(isset($_GET['search_type'])) 
{
	$change_page_url = $change_page_url."search_type=".$_GET['search_type'];
}

//Add search_key to link.
if(isset($_GET['search_key'])) 
{
	$change_page_url = $change_page_url."&search_key=".$_GET['search_key'];
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


//Next/Previous button. Headers to table.
include ("prev_next_buttons.php");
print(" <table>
			<tr>
				<th>Part ID</th>
				<th>Part name</th>
				<th>Part picture</th>
			</tr>
		");

$count = 0;
 while ($row = mysqli_fetch_array($result)) {

	
		//Set all variables.
		$itemtype_id = $row['ItemtypeID'];
		$part_name = $row['Partname'];
		$part_id = $row['PartID']; 
		$color_id = $row['ColorID'];
		 
		//Query to server IMAGE.
		$imagesearch = mysqli_query($connection, 
					"SELECT * 
					FROM images 
					WHERE 
						ItemTypeID='$itemtype_id' 
					AND 
						ItemID='$part_id' 
					AND 
						ColorID='$color_id'");
		//Send query.
		$imageInfo = mysqli_fetch_array($imagesearch);
		
		//Link to image server.
		$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		
		//Address to an image.
		$imagePath;
		
		//Check which file format the image has.
		if($imageInfo['has_jpg']) 
		{ 
			// Use JPG if it exists
			$filename = "$itemtype_id/$color_id/$part_id.jpg";
			$imagePath = $prefix.$filename;
		} 
		else if($imageInfo['has_gif']) 
		{ 
			// Use GIF if JPG is unavailable
			$filename = "$itemtype_id/$color_id/$part_id.gif";
			$imagePath = $prefix.$filename;
		} 
		else 
		{ 
			// If neither format is available, insert a placeholder image.
			$filename = "noimage.png";
			$imagePath = $filename;
		}
		
		
		if($count++ < $limit){
			//Create table row.
		print("<tr>
				<td>$part_id</td>
				<td><a href='part_page.php?ID=$part_id'>$part_name</a></td>
				<td> <img src=\"$imagePath\" alt=\"Image of $part_name\"> </td>
			   </tr>
				");
		}
		
	 
 } // end while
 
 //End of table/add prev-next buttons
 print("</table>");
 include ("prev_next_buttons.php");
 } else{print("<h3>Your search needs to contain least 3 characters.</h3>");}
?>