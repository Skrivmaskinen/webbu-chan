<?php
$search = $_GET['search'];
$limit = 50;
 // Connect to database
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Search for set name
 $result = mysqli_query($connection, "
		SELECT 
			sets.Setname, sets.SetID, sets.Year
		FROM 
			sets,inventory
		WHERE
			sets.SetID = inventory.SetID
		AND
			ItemID = '$search'
		GROUP BY
			Setname
		ORDER BY
			Setname
		LIMIT 
			$limit
		
		");
 // Print results
 print("<table>
			<tr>
				<th>Set ID</th>
				<th>Sets</th>
				<th>Year</th>
				<th>Set picture</th>
			</tr>
		");
 

 while ($row = mysqli_fetch_array($result)) {						  
		 //Set variables
		 $set_name = $row['Setname'];
		 $set_id = $row['SetID'];
		 $year = $row['Year'];
		
		$imagesearch = mysqli_query($connection, 
					"SELECT * 
					FROM images 
					WHERE 
						ItemID='$set_id' ");
		
		$imageInfo = mysqli_fetch_array($imagesearch);
		
		$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		
		$imagePath;
		
		//Get small images for table 
		if($imageInfo['has_jpg']) 
		{ 
			// Use JPG if it exists
			$filename = "S/$set_id.jpg";
			$imagePath = $prefix.$filename;
		} 
		else if($imageInfo['has_gif']) 
		{ 
			// Use GIF if JPG is unavailable
			$filename = "S/$set_id.gif";
			$imagePath = $prefix.$filename;
		}
		else 
		{ 
			// If neither format is available, insert a placeholder image
			$filename = "noimage.png";
			$imagePath = $filename;
		}
		
		//Create table
		print("<tr>
					<td>$set_id</td>
				   <td><a href='set_page.php?search=$set_id'>$set_name</a></td>
				   <td>$year</td>
				   <td><img src=\"$imagePath\"></td>
			   </tr>");
	 
 } // end while
 
 print("</table>"); //end table
 include ("prev_next_buttons.php");
?>