<?php
			$id = $_GET['ID'];
			
			if($_GET['showtype']=="M"){
				print("<ul>
						<li class='show_type_buttons'><a href=\"?ID=$id\">Parts</a></li>
						<li class='show_type_buttons'>Minifigs</li>
					</ul>");
				include("set_show_minifigs.php");
			}else{
				print("<ul>
						<li class='show_type_buttons'>Parts</li>
						<li class='show_type_buttons'><a href=\"?ID=$id&showtype=M\">Minifigs</a></li>
					</ul>");
				include("set_show_parts.php");
			}
		?>