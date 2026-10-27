<script>
	document.getElementById('btnDELETE').style.display = "none";
	document.getElementById('btnNEW').style.display = "none";


	let green = "#29ff266b", red = "#ff26266b";
	var records = document.getElementsByClassName('presente');
	for(let i=0;i<records.length;i++){
		color = green;
		if(records[i].innerHTML == "N")
			color = red;
		let celle = records[i].parentElement.cells;
		for(let j=0;j<celle.length;j++){
			celle[j].style.background = color;
		}
	}
</script>