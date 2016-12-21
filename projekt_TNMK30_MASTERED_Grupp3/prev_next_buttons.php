<?php
	print("<ul>
		<li class='prev_next_buttons'>");
				if($start_index == 0){
					print("prev");
				}else{
					print("<a href ='$prev_page'>
					prev
					</a>");
				}
	$first_result = $start_index+1;
	$last_result = $start_index+min($number_of_results, $limit);
	print("</li>
			<li>showing results $first_result - $last_result</li>
			<li class='prev_next_buttons'>");
			if($number_of_results == $limit+1){
				print("<a href ='$next_page'>
				next
				</a>");
			}else{
				print("next");
			}
	print("	</li>
	</ul>");
?>
