<?php
$limit = 50;

 // Get all colors for a part
 $result = mysqli_query($connection, "
		SELECT 
			DISTINCT Colorname
		FROM 
			parts, inventory, colors
		WHERE
				colors.ColorID=inventory.ColorID 
			AND 
				parts.PartID=inventory.ItemID
			AND
				PartID = '$search'
		ORDER BY
			Colorname
		LIMIT 
			$limit
		
		");
 // Write restults
 print("<table>");
 
 while ($row = mysqli_fetch_array($result)) {
		 //Set variables
		 $color_name = $row['Colorname'];
		 
		 //Write table
		 print("<tr>
					<td>$color_name</td>
				</tr>");
			
 } // end while
 
 print("</table>");
?>
