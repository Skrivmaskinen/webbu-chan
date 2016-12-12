<?php
$search = $_GET['search'];
$limit = 50;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Hämta setten som en bit finns i
 $result = mysqli_query($connection, "
		SELECT 
			DISTINCT Setname
		FROM 
			parts, inventory, sets
		
		WHERE 
				parts.PartID=inventory.ItemID
			AND 
				sets.SetID=inventory.SetID 
			AND
				PartID = '$search'
		ORDER BY
			Setname
		LIMIT 
			$limit
		
		");

 // Skriv ut alla poster i svaret
 print("<table>
			<tr>
				<th>Sets</th>
			</tr>
		");
 
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla vairiabler.
		 
		 $set_name = $row['Setname'];
		//Skapa tabellrad.
		print("<tr>
				   <td>$set_name</td>
			   </tr>
				");
 } // end while
 
 print("</table>");
?>