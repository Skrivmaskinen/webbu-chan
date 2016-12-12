<?php
$search = $_GET['search_key'];
$limit = 200;
 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt bitnamn
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
		
		");
 // Skriv ut alla poster i svaret
 print("<table>
			<tr>
				<th>Part ID</th>
				<th>Part name</th>
				<th>Part picture</th>
			</tr>
		");
 
 while ($row = mysqli_fetch_array($result)) {						  
		//Sätt alla vairiabler.
		$itemtype_id = $row['ItemtypeID'];
		 
		$part_name = $row['Partname'];
		$part_id = $row['PartID']; 
		$color_id = $row['ColorID'];
		 
		$imagesearch = mysqli_query($connection, "SELECT * 
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
		
		
		
		//Skapa tabellrad.
		print("<tr>
				<td>$part_id</td>
				<td><a href='http://www.student.itn.liu.se/~freno979/tnmk30/LegoMy/part_show_sets.php/?search=$part_id'>$part_name</a></td>
				<td> <img src=\"$imagePath\"> </td>
			   </tr>
				");
	 
 } // end while
 
 print("</table>");
?>