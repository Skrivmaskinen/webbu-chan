<?php
$search = $_GET['search'];
$limit = 50;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Hämta färgerna som en bit finns i
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

 // Skriv ut alla poster i svaret
 print("<table>
			<tr>
				<th>Colors</th>
			</tr>
		");
 
 while ($row = mysqli_fetch_array($result)) {
		 //Sätt alla variabler.
		 $color_name = $row['Colorname'];
		 
		 //Skapa tabellrad.
		 print("<tr>
					<td>$color_name</td>
				</tr>
				");
			
 } // end while
 
 print("</table>");
?>