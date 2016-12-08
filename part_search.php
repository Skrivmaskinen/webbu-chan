<?php
$search = $_GET['search'];
$limit = 50;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt bitnamn
 $result = mysqli_query($connection, "
		SELECT 
			DISTINCT Partname
		FROM 
			parts, inventory
		
		WHERE 
				parts.PartID=inventory.ItemID
			AND
				Partname LIKE '%$search%'
		ORDER BY
			Partname
		LIMIT 
			$limit
		
		");

 // Skriv ut alla poster i svaret
 print("<table>
			<tr>
				<th>Parts</th>
			</tr>
		");
 
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla vairiabler.
		 
		 $part_name = $row['Partname'];
		//Skapa tabellrad.
		print("<tr>
				   <td>$part_name</td>
			   </tr>
				");
	 
 } // end while
 
 print("</table>");
?>