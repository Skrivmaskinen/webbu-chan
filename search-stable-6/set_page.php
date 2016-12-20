<?php
	include("header.php");
?>
<script src="script.js"></script>
			<div class="itemdetails">
				<?php include("set_info.php"); ?>
			</div>
		<?php
			print("<ul>
						<li class='show_type_buttons'>Parts</li>
						<li class='show_type_buttons'><a href='adwad'>Minifigs</a></li>
					</ul>");
			if($_GET['']=="p"){
				include("set_show_minifigs.php");
			}else{
				include("set_show_parts.php");
			}
		?>
		</div>
	</body>
</html>