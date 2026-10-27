function newUtente(){
	window.open("base/utenti/nuovoUtente.php","NUOVO UTENTE","width=500,height=400")
}

function nuovoAdmin() {
	var oDiv = document.getElementById('insAdmin');
	var oBtn = document.getElementById('btnNuovoAdmin');
	if (oBtn.value=='NUOVO ADMIN') {
		oDiv.style.display = 'block';
		oBtn.value='NASCONDI';
	} else {
		oDiv.style.display = 'none';
		oBtn.value='NUOVO ADMIN';
	}
}

function fnExcelReport(){
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('tableexport'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}

function mostraLegenda(id,Source) {
	if(Source == 1){
		var divLegenda = document.getElementById(id);
		divLegenda.style.display = "block";
	}else if(Source == 0){
		var divLegenda = document.getElementById(id);
		divLegenda.style.display = "none";
	}

}

function mostraModOre(){
	var x = document.getElementById("tableModOre").style.display;
	if(x == "block"){
		 document.getElementById("tableModOre").style.display = "none";
		 document.getElementById("labelModOre").innerHTML = "MODIFICA ORE &#9660;";
	}else{
		document.getElementById("tableModOre").style.display = "block";
		 document.getElementById("labelModOre").innerHTML = "MODIFICA ORE &#9650;";
	}
}