function modalImage() {	
	//Get the image, the modal, and the modals image.
	var modal = document.getElementById('the_modal');
	var modalImg = document.getElementById('img01');
	var focusImg = document.getElementById('focus_image');
		
	//...show the modal. 
	modal.style.display = "block";
	modalImg.src = focusImg.src;

	modal.onclick = function() {
		modal.style.display = "none";
	}	
}

//----------------------------------------------------------
//THIS CODE WAS INSPIRED FROM
//http://www.w3schools.com/howto/howto_css_modal_images.asp 
//-----------------------------------------------------------
