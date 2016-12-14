<?php
$search = $_GET['search_key'];

//Maximum number of results.
$limit = 50;

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
$result = mysqli_query($connection, "
		SELECT 
			Partname, PartID, ItemtypeID, inventory.ColorID
		FROM 
			parts, inventory, colors
		
		WHERE 
				parts.PartID=inventory.ItemID
			AND
				Partname LIKE '%$search%'
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

//Result without limit.
/*
$number_of_results = mysqli_query($connection, "
		SELECT 
			Partname, PartID, ItemtypeID, inventory.ColorID
		FROM 
			parts, inventory, colors
		
		WHERE 
				parts.PartID=inventory.ItemID
			AND
				Partname LIKE '%$search%'
			AND
				inventory.ColorID = colors.ColorID
		GROUP BY
			Partname
		ORDER BY
			Partname
		
		");

$rows = mysqli_num_rows($number_of_results);
<!-- Results: $rows -->
*/

//Link to next page

$change_page_url = "?";

if(isset($_GET['search_type'])) 
{
	$change_page_url = $change_page_url."search_type=".$_GET['search_type'];
}

if(isset($_GET['search_key'])) 
{
	$change_page_url = $change_page_url."&search_key=".$_GET['search_key'];
}

$start_index_next = 50;
$start_index_prev = 0;

if(isset($_GET['start_index'])) 
{
	$start_index_next = $_GET['start_index'] + 50;
	
	if($_GET['start_index'] >= 50)
	{
		$start_index_prev = $_GET['start_index'] - 50;
	}
	
}
$prev_page = $change_page_url."&start_index=".$start_index_prev;
$next_page = $change_page_url."&start_index=".$start_index_next;


//Headers to table.
print("
		<p class='prev_next_buttons'>
			<a href ='$prev_page'>
				prev
			</a>
		</p>
		<p class='prev_next_buttons'>
			<a href ='$next_page'>
				next
			</a>
		</p>
		<table>
			<tr>
				<th>Part ID</th>
				<th>Part name</th>
				<th>Part picture</th>
			</tr>
		");


 while ($row = mysqli_fetch_array($result)) {						  
		//Set all variables.
		$itemtype_id = $row['ItemtypeID'];
		$part_name = $row['Partname'];
		$part_id = $row['PartID']; 
		$color_id = $row['ColorID'];
		 
		//Query to server IMAGE.
		$imagesearch = mysqli_query($connection, "SELECT * 
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
		
		//Addres to an image.
		$imagePath;
		
		//Check which file format the image has.
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
			// If neither format is available, insert a placeholder image.
			$filename = "noimage.png";
			$imagePath = $filename;
		}
		
		
		
		//Create table row.
		print("<tr>
				<td>$part_id</td>
				<td><a href='part_show_sets.php/?search=$part_id'>$part_name</a></td>
				<td> <img src=\"$imagePath\"> </td>
			   </tr>
				");
	 
 } // end while
 
 print("</table>");
?>