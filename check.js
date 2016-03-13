  function validateForm() {
    var x = document.forms["kalkuliatorius"]["p_verte"].value;
	var y = document.forms["kalkuliatorius"]["s_verte"].value;
	var i = document.getElementById("i");
	var ii = document.getElementById("ii");
	var klaidos =0;
	
	
	if (x == null || x == "")
		
		{
			
		i.style.backgroundColor = "red";
			klaidos = klaidos +1;
			
		}
	else {
		
		i.style.backgroundColor = "";
	}
	
	if (y == null || y == "")
		
		{
			
		ii.style.backgroundColor = "red";	
		 klaidos = klaidos +1;
		}
	else {
		
		ii.style.backgroundColor = "";
	}
	
	if (klaidos > 0) {
		
		 return false;
	}
	
}