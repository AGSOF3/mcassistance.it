function verificaComp(id){
	if(document.getElementById(id).value == null || document.getElementById(id).value == ""){
		document.getElementById(id).style.backgroundColor = "#FF6666";
		document.getElementById(id).style.border = "1px solid black";
		document.getElementById(id).classList.add ("palceholderBlack");
	}
	else{
		document.getElementById(id).style.backgroundColor = "white";
	}
}


function checkAll(idForm){

}