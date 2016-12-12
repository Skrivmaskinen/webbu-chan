<?php
$search = $_GET['search_key'];
$limit = 50;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt setnamn
 $result = mysqli_query($connection, "
		SELECT 
			sets.Setname, sets.SetID, inventory.ItemtypeID
		FROM 
			sets, inventory
		WHERE 
			Setname LIKE '%$search%'
		AND
			sets.SetID=inventory.ItemID
		ORDER BY
			Setname
		LIMIT 
			$limit
		
		");

 // Skriv ut alla poster i svaret
 print("<table>
			<tr>
				<td>Set ID</td>
				<th>Sets</th>
				<th>Set picture</th>
			</tr>
		");
 
 //Loopa igenom alla rader
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla variabler.
		 $set_name = $row['Setname'];
		 $set_id = $row['SetID'];
		 $itemtype_id = $row['ItemtypeID'];
		 
		$imagesearch = mysqli_query($connection, "SELECT * 
												FROM images 
												WHERE 
													ItemTypeID='$itemtype_id' 
												AND 
													ItemID='$set_id' 
												");
		
		$imageInfo = mysqli_fetch_array($imagesearch);
		
		$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		
		$imagePath;
		
		if($imageInfo['has_jpg']) 
		{ 
			// Use JPG if it exists
			$filename = "$itemtype_id/$set_id.jpg";
			$imagePath = $prefix.$filename;
		} 
		else if($imageInfo['has_gif']) 
		{ 
			// Use GIF if JPG is unavailable
			$filename = "$itemtype_id/$set_id.gif";
			$imagePath = $prefix.$filename;
		} 
		else 
		{ 
			// If neither format is available, insert a placeholder image
			$filename = "noimage.png";
			$imagePath = $filename;
		}
		
		//Skapa tabellrad.
		print("<tr>
					<td>$set_id</td>
				   <td><a href='http://www.student.itn.liu.se/~freno979/tnmk30/LegoMy/set_show_parts.php/?search=$set_id'>$set_name</a></td>
				   <td><img src=\"$imagePath\"></td>
				   
				   
				   
			   </tr>");
	 
 } // end while
 
 print("</table>"); //end table
?>