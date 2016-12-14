<?php
$search = $_GET['search'];
$limit = 50;
 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt setnamn
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
 // Skriv ut alla poster i svaret
 print("<table>
			<tr>
				<th>Set ID</th>
				<th>Sets</th>
				<th>Year</th>
				<th>Set picture</th>
			</tr>
		");
 
 //Loopa igenom alla rader
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla variabler.
		 $set_name = $row['Setname'];
		 $set_id = $row['SetID'];
		 $year = $row['Year'];
		
		$imagesearch = mysqli_query($connection, "SELECT * 
												FROM images 
												WHERE 
													
													ItemID='$set_id' 
												");
		
		$imageInfo = mysqli_fetch_array($imagesearch);
		
		$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		
		$imagePath;
		
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
		else if($imageInfo['has_largegif'])
		{
			// Use JPG if it exists
		$filename = "S/$set_id.gif";
		$imagePath = $prefix.$filename;
		}
		else if($imageInfo['has_largejpg'])
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
		$a = $imageInfo['has_gif'];
		//Skapa tabellrad.
		print("<tr>
					<td>$set_id</td>
				   <td><a href='set_page.php?search=$set_id'>$set_name</a></td>
				   <td>$year</td>
				   <td><img src=\"$imagePath\"></td>
				   
				   
				   
			   </tr>");
	 
 } // end while
 
 print("</table>"); //end table
?>