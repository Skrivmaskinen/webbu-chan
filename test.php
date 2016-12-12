<?php
	
	//Establish a connection
	$connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
	
	//Get a table from inventory, parts and colors (might change later)
	$result = mysqli_query($connection, "
										SELECT 
											inventory.ItemtypeID,
											inventory.ItemID,
											inventory.ColorID,
											parts.Partname,
											colors.Colorname
										FROM	
											inventory,
											parts,
											colors
										WHERE
											inventory.ItemID = parts.PartID
											AND
											inventory.ColorID = colors.ColorID
											AND
											inventory.SetID='375-2' 
											AND
											inventory.ItemTypeID='P' 
										
										LIMIT 50");
	
	print("<table> <tr>Thingies</tr>");
	
	while($row = mysqli_fetch_array($result)) {
		
		$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		
		$ItemtypeID = $row['ItemtypeID'];
		$ItemID = $row['ItemID'];
		$ColorID = $row['ColorID'];
		
		$imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' AND ColorID=$ColorID");
		$imageInfo = mysqli_fetch_array($imagesearch);
		
		$imagePath;
		
		if($imageInfo['has_jpg']) 
		{ 
			// Use JPG if it exists
			$filename = "P/$ColorID/$ItemID.jpg";
			$imagePath = $prefix.$filename;
		} 
		else if($imageInfo['has_gif']) 
		{ 
			// Use GIF if JPG is unavailable
			$filename = "P/$ColorID/$ItemID.gif";
			$imagePath = $prefix.$filename;
		} 
		else 
		{ 
			// If neither format is available, insert a placeholder image
			$filename = "noimage.png";
			$imagePath = $filename;
		}
		
		print("<tr> 
			<td>
				$ItemtypeID
			</td> 
			<td>
				$ItemID
			</td>
			<td>
				$ColorID
			</td>
			<td>
				<img src=\"$imagePath\">
			</td>
		</tr>
		");
	}
	
	print("</table>");


?>
<!-- inventory.ItemtypeID, 
											inventory.ItemID,
											images.ItemID, 
											images.ColorID,
											colors.ColorID 
											FROM 
											inventory,										
											images,
											colors
										WHERE
											inventory.ItemID = images.ItemID
											AND
											images.ColorID = colors.ColorID
											-->