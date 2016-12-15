<?php
$search = $_GET['search_key'];
//Maximum number of results.
$limit = 20;

//Initialize start_index to 0. (In case there is none in URL)
$start_index = 0;

//If there exist a start index in the URL, change start_index to that.
if(isset($_GET['start_index']))
{
	$start_index = $_GET['start_index'];
}

// Connect to database.
$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");

//Query to server.
$result = mysqli_query($connection, "
		SELECT 
			sets.Setname, sets.SetID, sets.Year
		FROM 
			sets
		WHERE 
			Setname LIKE '%$search%'
		GROUP BY
			Setname
		ORDER BY
			Setname
		LIMIT 
			$limit
		Offset
			$start_index ");

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
				<th>Set ID</th>
				<th>Sets</th>
				<th>Year</th>
				<th>Set picture</th>
			</tr>");
 
 //Loop through all rows.
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla variabler.
		 $set_name = $row['Setname'];
		 $set_id = $row['SetID'];
		 $year = $row['Year'];
		
		$imagesearch = mysqli_query($connection, 
					"SELECT * 
					FROM images 
					WHERE 
						ItemID='$set_id' ");

		$imageInfo = mysqli_fetch_array($imagesearch);
		
		//
		$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		
		$imagePath;
		
		if($imageInfo['has_jpg']) 
		{ 
			//Use JPG if it exists. 
			$filename = "S/$set_id.jpg";
			$imagePath = $prefix.$filename;
		} 
		else if($imageInfo['has_gif']) 
		{ 
			//Use GIF if JPG is unavailable.
			$filename = "S/$set_id.gif";
			$imagePath = $prefix.$filename;
		}
		else if($imageInfo['has_largegif'])
		{
			//Use JPG if it exists.
		$filename = "S/$set_id.gif";
		$imagePath = $prefix.$filename;
		}
		else if($imageInfo['has_largejpg'])
		{
			//Use JPG if it exists.
		$filename = "S/$set_id.jpg";
		$imagePath = $prefix.$filename;
		}
		else 
		{ 
			// If neither format is available, insert a placeholder image.
			$filename = "noimage.png";
			$imagePath = $filename;
		}
		
		//Create tablerow with id, name, year and picture.
		print("<tr>
					<td>$set_id</td>
				   <td><a href='set_page.php?search=$set_id'>$set_name</a></td>
				   <td>$year</td>
				   <td><img src=\"$imagePath\"></td>
			   </tr>");
	 
 } // end while
 
//End of table/add prev-next buttons
 print("</table>");
 include ("prev_next_buttons.php");
?>
