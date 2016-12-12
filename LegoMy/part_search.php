<?php
$search = $_GET['search_key'];
$limit = 200;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt bitnamn
 $result = mysqli_query($connection, "
		SELECT 
			Partname, PartID
		FROM 
			parts, inventory
		
		WHERE 
				parts.PartID=inventory.ItemID
			AND
				Partname LIKE '%$search%'
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
				<th>Parts</th>
			</tr>
		");
 
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla vairiabler.
		 
		 $part_name = $row['Partname'];
		 $part_id = $row['PartID'];
		//Skapa tabellrad.
		print("<tr>
				   <td><a href='http://www.student.itn.liu.se/~freno979/tnmk30/LegoMy/part_page.php?search=$part_id'>$part_name</a></td>
			   </tr>
				");
	 
 } // end while
 
 print("</table>");
?>