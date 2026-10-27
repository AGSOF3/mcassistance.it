// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.visibility = "hidden";
  modal.style.opacity= "0";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.visibility = "hidden";
    modal.style.opacity= "0";
  }
}

function apriQR(data){
		modal.style.visibility = "visible";
		modal.style.opacity= "1";
		let qr = document.getElementById('QRCode').value;
		document.getElementById('actionsFrame').src = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="+qr;
}