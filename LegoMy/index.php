<?php include "header.txt" ?>
			<div id="text"> 
			Search for ...
			</div>
			
			<div id="wrapper">
				<form>
					<!--part-->
					
					<input id="part_form" type="radio" name="search_type" value = "Part">
					<label id="part_form_visual" class="button" for="part_form">Part</label>
					<input id="set_form" type="radio" name="search_type" value = "Set" checked>
					<label id="set_form_visual" class="button" for="set_form">Set</label>
					<br>
					<div id="search_container">
						<input id="search_bar" type="text" placeholder="search lego" name="search_key" >
						<input id="submit_button" type="submit" value="search">
					</div>
				</form>
		
				<!-- Keep Part/Set checked -->
				
				<script type="text/javascript">
					
					
					var search_type = "<?php echo $_GET['search_type']; ?>";
					var search_key = "<?php echo $_GET['search_key']; ?>";
					
					
					if(search_type == "Part") {
						document.getElementById('part_form').checked = true;
					}
					else if(search_type == "Set") {
						document.getElementById('set_form').checked = true;
					}
					document.getElementById('search_bar').value = search_key;
					
				
				</script>				
				
				
				<!-- Print out search results -->
				<?php
					$search_type = $_GET['search_type'];
				
					if($search_type == 'Part'){
						
						include "part_search.php";
						
						
					}else if($search_type == 'Set'){
						
						include "set_search.php";
						
						
					}else{
						
						
					}
					
				
				?>
				
			</div>
		</div>
		

		
	</body>


</html>