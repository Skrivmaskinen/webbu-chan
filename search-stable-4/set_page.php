<?php
	include("header.txt");
?>
&nbsp;	
			<div id="partdetails">
				<?php
				$search = $_GET['search'];
				$limit = 50;
				 // Koppla upp mot databasen
				 $connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
				 // Sök efter ungefärligt setnamn
				 
				 $result = mysqli_query($connection, "
						SELECT 
							*
						FROM 
							sets, categories
						WHERE
							sets.CatID = categories.CatID
						AND
							SetID = '$search'
						LIMIT 
							$limit
						
						");
				 // Skriv ut alla poster i svaret
				 
				 
				 //Loopa igenom alla rader
				 while ($row = mysqli_fetch_array($result)) {						  
						 //Sätt alla variabler.
						 $set_name = $row['Setname'];
						 $set_id = $row['SetID'];
						 $year = $row['Year'];
						 $category = $row['Categoryname'];
						
						$imagesearch = mysqli_query($connection, "SELECT * 
																FROM images 
																WHERE 
																	
																	ItemID='$set_id' 
																");
						
						$imageInfo = mysqli_fetch_array($imagesearch);
						
						$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
						
						$imagePath;
						
						if($imageInfo['has_jpg']) 
						{ 
							// Use JPG if it exists
							$filename = "S/$set_id.jpg";
							$imagePath = $prefix.$filename;
						} 
						else if($imageInfo['has_gif']) 
						{ 
							// Use GIF if JPG is unavailable
							$filename = "S/$set_id.gif";
							$imagePath = $prefix.$filename;
						}
						else if($imageInfo['has_largegif'])
						{
							// Use JPG if it exists
						$filename = "S/$set_id.gif";
						$imagePath = $prefix.$filename;
						}
						else if($imageInfo['has_largejpg'])
						{
							// Use JPG if it exists
						$filename = "S/$set_id.jpg";
						$imagePath = $prefix.$filename;
						}
						else 
						{ 
							// If neither format is available, insert a placeholder image
							$filename = "noimage.png";
							$imagePath = $filename;
						}
						$a = $imageInfo['has_gif'];
						//Skapa tabellrad.
						print("
							   <h1>$set_name</h1>
								<img src=\"$imagePath\">
								<p><span>SetID:</span> $set_id</p>
								<p><span>Year:</span> $year</p>
								<p><span>Category:</span> $category</p>
								");
					 
				 } // end while
				 
				?>
			</div>
		<?php include("set_show_parts.php"); ?>
		</div>
	</body>
</html>