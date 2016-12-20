// When the page is loaded...
window.onload = function() {
	//Get the image, the modal, and the modals image.
	var modal = document.getElementById('the_modal');

	var img = document.getElementById('focus_image');
	var modalImg = document.getElementById('img01');
	//When the 'normal' image is clicked...
	img.onclick  = function() {
		//...show the modal.
		modal.style.display = "block";
		modalImg.src = this.src;
	}
	//Close the modal when the 'X' is clicked.
	var span = document.getElementById("close");

	modal.onclick = function() {
		modal.style.display = "none";
	}	
}

//----------------------------------------------------------
//THIS CODE WAS INSPIRED FROM
//http://www.w3schools.com/howto/howto_css_modal_images.asp 
//-----------------------------------------------------------
