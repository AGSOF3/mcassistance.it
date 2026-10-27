function UtenteOreOL(){
//	let maxWidth = window.screen.availWidth;
//	let maxHeight = window.screen.availHeight;
//	window.moveTo(maxWidth/2,maxHeight/2);
	window.resizeTo(700,620);
}


// Get the modal
var modal = document.getElementById("myModal");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];



// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.visibility = "hidden";
  modal.style.opacity= "0";
  parent.location.reload();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.visibility = "hidden";
    modal.style.opacity= "0";
    parent.location.reload();
  }
}

function apriDettaglioOre(data){
		modal.style.visibility = "visible";
		modal.style.opacity= "1";
		let key = document.getElementById('thKey').value;
		document.getElementById('frameDettaglioOre').src = "DettaglioOre.php?Key="+key+"&Data="+data;
}