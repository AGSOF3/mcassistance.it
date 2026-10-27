<script>

	document.getElementById('btnDELETE').style.display = "none";
	document.getElementById('btnNEW').style.display = "none";

	
	var btnExcel = document.createElement('button');
	btnExcel.id = "ExcelAll";
	btnExcel.className = "btn btn-secondary";
	btnExcel.name = "action";
	btnExcel.value = "EXCEL";
	btnExcel.innerHTML = "EXCEL";
	var ref = (document.getElementById('btnDELETE'));
	insertAfter(btnExcel,ref);
	function insertAfter(el, referenceNode) { 
		referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
	}
	
</script>