<?php
	// Print out search results
	$search_type = $_GET['search_type'];
			
	if($search_type == 'Part'){
		include "part_search.php";
	}else if($search_type == 'Set'){
		include "set_search.php";
	}
?>