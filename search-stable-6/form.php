<form action="index.php">

	<!--part-->
	<input id="part_form" type="radio" name="search_type" value = "Part" checked>
	<label id="part_form_visual" class="button" for="part_form">Part</label>
	
	<!--set-->
	<!-- Keep Part/Set checked -->
	<input id="set_form" type="radio" name="search_type" value = "Set"
		<?php if($_GET['search_type'] == "Set"){ print("checked");} ?>>
	<label id="set_form_visual" class="button" for="set_form">Set</label>
	<br>
		<input id="search_bar" type="text" placeholder="search lego" name="search_key" 
			value="<?php print($_GET['search_key']); ?>">
		<input id="submit_button" type="submit" value="search">
</form>