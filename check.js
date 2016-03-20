 function isNumeric(n) {
  return !isNaN(parseFloat(n))&&(parseFloat(n)>=0);
}

 function validateForm(s) {
  
  
  
    var x = document.forms["kalkuliatorius"]["p_verte"].value;
	var y = document.forms["kalkuliatorius"]["s_verte"].value;
	
	var i = document.getElementById("i");
	var ii = document.getElementById("ii");
	
	if (s ==2)
	
	{
	var iii = document.getElementById("iii");
	var z = document.forms["muito_tarifas"]["p_muito_tarifas"].value;
	
	}
	
	
	var klaidos =0;
	
	
	if (!isNumeric(x))
		
		{
			
		i.style.backgroundColor = "red";
			klaidos = klaidos +1;
			
		}
	else {
		
		i.style.backgroundColor = "";
	}
	
	if (!isNumeric(y))
		
		{
			
		ii.style.backgroundColor = "red";	
		 klaidos = klaidos +1;
		}
	else {
		
		ii.style.backgroundColor = "";
	}
	
	
	if (s ==2) {
	
			if (!isNumeric(z)||(parseFloat(z)<0.01))
		
		{
			
		iii.style.backgroundColor = "red";
			klaidos = klaidos +1;
			
		}
	else {
		
		iii.style.backgroundColor = "";
	}
	}
	
	
	
	if (klaidos > 0) {
		
		 return false;
	}
	
}