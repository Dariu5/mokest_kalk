<!doctype html>

<html lang="lt">
<head>
  <meta charset="utf-8">

  <title>Importo mokesčių kalkuliatorius</title>
  <meta name="description" content="Importo mokesčių kalkulaitorius">
  <meta name="author" content="radiocool.lt">

<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>

<?php

$komerc_pvm_nuo = 22;
$ne_komerc_pvm_nuo =45;

$muito_mokest_nuo =150;
$past_ne_komer_muito_mokestis_iki =700;



$PVM_taikomas = false;
$muitas_taikomas = 0;

$p_verte = $_POST['p_verte'];
$s_verte = $_POST['s_verte'];
$komercine = $_POST['ar_komercine'];
$sent = $_POST['sent'];
$suma = $p_verte + $s_verte;

?>

 <script type="text/javascript" src="check.js"></script>

 <form name="kalkuliatorius" action="index.php" method="post" onsubmit="return validateForm()">
  Prekių vertė, eur:<br>
<?php
echo '
  <input type="text" name="p_verte" id ="i" value ="'.$p_verte.'"><br>
  Siuntimo kaina, eur:<br>
  <input type="text" name="s_verte" id ="ii" value ="'.$s_verte.'"><br>
  <br>
  Ar siunta yra komercinio pobūdžio?:<br>';
  
  if ($sent == 1)
	  
	  {
		  if ($komercine == 'taip' )
				{$komercine_taip = 'checked';
					$komercine_ne = '';}
		  
		  else {	$komercine_taip = '';
					$komercine_ne = 'checked';}
		  
		  echo '<input type="radio" name="ar_komercine" value="taip" '.$komercine_taip.'>Taip<br>
				<input type="radio" name="ar_komercine" value="ne" '.$komercine_ne.'>Ne (Gavėjas ir siuntėjas yra fizinis asmuo, prekės gaunamos neatlygintanai)<br>';
		    	  
		  	  }
  
  else echo '<input type="radio" name="ar_komercine" value="taip" checked>Taip<br>
				<input type="radio" name="ar_komercine" value="ne" >Ne (Gavėjas ir siuntėjas yra fizinis asmuo, prekės gaunamos neatlygintanai)<br>';
  
  echo' 
  
  <br>
  <input type="submit" class="button" value="Skaičiuoti"><br>
  <br>
   Viso, eur:<br>
  <input type="text" name="v_verte" value="'.$suma.'"><br>
  <input type="hidden" name="sent" value="1"><br>
</form>';

 if ($sent == 1) {
	 
	 // ar taikomas PVM?
	 if ($komercine == 'taip') 
		 
		 {if ($p_verte>$komerc_pvm_nuo)
			  $PVM_taikomas = true;     
					else $PVM_taikomas = false; 
		 }				
		else {if ($p_verte>$ne_komerc_pvm_nuo)
		 
				{  $PVM_taikomas = true;     }
		 
		else $PVM_taikomas = false; }
							 

		// ar taikomas muitas? 0 - ne, 1- pastovus, 2 - pagal tarifą					 
	if ($p_verte > $muito_mokest_nuo)

	{ 
		if (($komercine == 'ne')&&($p_verte<$past_ne_komer_muito_mokestis_iki))
			$muitas_taikomas =1;
			else $muitas_taikomas =2;
		
		
	}
		
		else  $muitas_taikomas =0;		
							 
	// formuojamas PVM komentaras lentelėje						 
if ($PVM_taikomas == true)

{
$PVM_taikomas_string = '<td bgcolor="#FF0000">Taip</td>';

if ($komercine == 'taip')
	
	{$PVM_komentaras_string ='PVM mokestis taikomas, nes <b>prekių vertė ( ' .$p_verte. ' eur) yra didesnė negu riba ( ' .$komerc_pvm_nuo. ' eur) </b> iki kurios netaikomas mokestis <b>komercinėms siuntoms.</b> ';}
	
	else
		{$PVM_komentaras_string ='PVM mokestis taikomas, nes <b>prekių vertė ( ' .$p_verte. ' eur) yra didesnė negu riba ( ' .$ne_komerc_pvm_nuo. ' eur)</b>  iki kurios netaikomas mokestis <b>ne komercinėms siuntoms.</b> ';}



}
else 
	
{	
$PVM_taikomas_string ='<td bgcolor="#00FF00">Ne</td>';
$PVM_komentaras_string ='';
}

// formuojamas muito komentaras lentelėje		

if ($muitas_taikomas > 0)
	
	{
		
		$muitas_taikomas_string = '<td bgcolor="#FF0000">Taip</td>';
		$muitas_taikomas_komentaras_string ='Muito mokestis yra taikomas, kadangi prekių vertė <b>prekių vertė ( ' .$p_verte. ' eur) yra didesnė negu riba ( ' .$muito_mokest_nuo. ' eur) </b> iki kurios netaikomas muito mokestis. ';
		
	}



	else 
	
	{
		
		$muitas_taikomas_string ='<td bgcolor="#00FF00">Ne</td>';
		$muitas_taikomas_komentaras_string ='';
		
	}

	
echo '
<table width="500">
  <tr>
    <th>Mokestis</th>
    <th>Ar taikomas</th>
    <th>Komentaras</th>
  </tr>
  <tr>
    <td>PVM</td>
    '.$PVM_taikomas_string.'
    <td>'.$PVM_komentaras_string.'</td>
  </tr>
  <tr>
    <td>Muito</td>
    '.$muitas_taikomas_string.'
    <td>'.$muitas_taikomas_komentaras_string.'</td>
  </tr>
</table>
';
 }
 ?>