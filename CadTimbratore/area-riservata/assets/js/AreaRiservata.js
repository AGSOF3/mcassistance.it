function mostraNascondiCard(card){
	if(card.className.includes("cAperta")){
		card.children[1].style.display = "none";
		card.className = "ccard cChiusa";
	}else{
		var children = document.getElementById('card002').parentNode.children;
		for (var i = 0; i < children.length; i++) {
			var child = children[i];
			if(child != card && child.className.includes("cAperta"))
				mostraNascondiCard(child);
		}		
		card.children[1].style.display = "block";
		card.className = "ccard cAperta";
	}
}