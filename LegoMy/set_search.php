<?php
$search = $_GET['search_key'];
$limit = 50;

 // Koppla upp mot databasen
 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
 // Sök efter ungefärligt setnamn
 $result = mysqli_query($connection, "
		SELECT 
			Setname, SetID
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
		 $set_id = $row['SetID'];
		 
		//Skapa tabellrad.
		print("<tr>
				   <td><a href='http://www.student.itn.liu.se/~freno979/tnmk30/LegoMy/set_show_parts.php/?search=$set_id'>$set_name</a></td>
			   </tr>");
	 
 } // end while
 
 print("</table>"); //end table
?>