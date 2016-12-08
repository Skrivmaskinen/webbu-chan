<?php
$search = $_GET['search'];
$limit = 50;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt setnamn
 $result = mysqli_query($connection, "
		SELECT 
			DISTINCT Setname
		FROM 
			sets
		WHERE 
			Setname LIKE '%$search%'
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
 
 //Loopa igenom alla rader
 while ($row = mysqli_fetch_array($result)) {						  
		 //Sätt alla variabler.
		 $set_name = $row['Setname'];
		 
		//Skapa tabellrad.
		print("<tr>
				   <td>$set_name</td>
			   </tr>");
	 
 } // end while
 
 print("</table>"); //end table
?>