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
session_start();
$komerc_pvm_nuo = 22;
$ne_komerc_pvm_nuo =45;

$muito_mokest_nuo =150;
$past_ne_komer_muito_mokestis_iki =700;

$PVM_tarifas = 21;
$pastovus_muito_tarifas = 2.5;
$tarpininko_mokestis = 8.69;

$PVM_taikomas = false;
$tarpininkas_taikomas = false;
$muitas_taikomas = 0;

if (!empty($_POST['p_verte']))
	
	$_SESSION["p_verte"] = $_POST['p_verte'];
			
	
	
if (!empty($_POST['s_verte']))
	$_SESSION["s_verte"]= $_POST['s_verte'];


if (!empty($_POST['ar_komercine']))
	$_SESSION["ar_komercine"]= $_POST['ar_komercine'];

$p_muito_tarifas = $_POST['p_muito_tarifas'];

$p_verte =$_SESSION["p_verte"];
$s_verte =$_SESSION["s_verte"];
$komercine =$_SESSION["ar_komercine"];

$sent = $_POST['sent'];


$muito_mokestis =0;
$PVM_mokestis=0;
$viso_mokesciu=0;
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
  
  if ($sent > 0)
	  
	  {
		  if ($komercine == 'taip' )
				{$komercine_taip = 'checked';
					$komercine_ne = '';}
		  
		  else {	$komercine_taip = '';
					$komercine_ne = 'checked';}
		  
		  echo '<input type="radio" name="ar_komercine" value="taip" '.$komercine_taip.'>Taip<br>
				<input type="radio" name="ar_komercine" value="ne" '.$komercine_ne.'>Ne (Gavėjas ir siuntėjas yra fizinis asmuo, prekės gaunamos neatlygintinai)<br>';
		    	  
		  	  }
  
  else echo '<input type="radio" name="ar_komercine" value="taip" checked>Taip<br>
				<input type="radio" name="ar_komercine" value="ne" >Ne (Gavėjas ir siuntėjas yra fizinis asmuo, prekės gaunamos neatlygintinai)<br>';
  
  echo' 
  
  <br>
  <input type="submit" class="button" value="Tikrinti"><br>
  <br>
   <input type="hidden" name="sent" value="1"><br>
</form>';

 if ($sent > 0) {
	 
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

// Ar taikomas tarpiniko mokestis?

if (($PVM_taikomas)||($muitas_taikomas))
	$tarpininkas_taikomas = true;
else $tarpininkas_taikomas = false;

if ($tarpininkas_taikomas)
	
	{$tarpininkas_taikomas_string = '<td bgcolor="#FF0000">Taip</td>';
	$tarpininkas_taikomas_komentaras_string = 'Kadangi siuntai priskaičiuoti importo mokesčiai Lietuvos paštas ima atlygį už muitinės tarpininko paslaugą.';}
	
	else
		
{$tarpininkas_taikomas_string ='<td bgcolor="#00FF00">Ne</td>';
$tarpininkas_taikomas_komentaras_string ='';}
	
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
  <tr>
    <td>Muitinės tarpininko</td>
    '.$tarpininkas_taikomas_string.'
    <td>'.$tarpininkas_taikomas_komentaras_string.'</td>
  </tr>
</table><br>';

if ($muitas_taikomas == 2)
	
	{
		echo'
		<br>
		<b> Nurodykite muito tarifą, %</b>
		<form name="kalkuliatorius" action="index.php" method="post" onsubmit="return validateForm()">
		<input type="text" name="p_muito_tarifas" id ="iii" ><br>
		<br>
		<input type="submit" class="button" value="Skaičiuoti"><br>
		<br>
		<input type="hidden" name="sent" value="2"><br>
		</form>
		';
	}
 
 
 if (($muitas_taikomas <= 1)||($sent ==2)) {
 
 
 if (($PVM_taikomas== true)||($muitas_taikomas >0 )|| ($tarpininkas_taikomas==true)) 
	 
	 {


	 if ($muitas_taikomas== 1)
			
			{
				
				$muito_mokestis =  $p_verte * $pastovus_muito_tarifas/100;
				
			}
			
			 if ($muitas_taikomas== 2)
			
			{
				
				$muito_mokestis =  $p_verte * $p_muito_tarifas/100;
				
			}
	 
		if ($PVM_taikomas== true)
			
			{
				
				$PVM_mokestis = ($p_verte + $s_verte + $muito_mokestis + $tarpininko_mokestis) *$PVM_tarifas/100; 
				
			}
		
			
			

$viso_mokesciu = $muito_mokestis + $PVM_mokestis + $tarpininko_mokestis;

	 echo '<table width="500">
  <tr>
    <th>Mokestis</th>
    <th>Suma</th>
    <th>Komentaras</th>
  </tr>';
  
  if ($muitas_taikomas >0)
	  
	  { echo '
		 <tr>
    <td>Muito</td>
    <td>'.$muito_mokestis.'</td>
    <td></td>
	</tr>
	 '
		  	  ;}  
 if ($PVM_taikomas)
	  
	  { echo '
		 <tr>
    <td>PVM</td>
    <td>'.$PVM_mokestis.'</td>
    <td></td>
	</tr>
	 '
		  	  ;} 

if ($tarpininkas_taikomas)
	  
	  { echo '
		 <tr>
    <td>Muitinės tarpininko</td>
    <td>'.$tarpininko_mokestis.'</td>
    <td></td>
	</tr>
	 '
		  	  ;}
   
   echo '
   
   <tr>
    <td>Viso:</td>
    <td>'.$viso_mokesciu.'</td>
    <td></td>
	</tr>
   
</table>';
		 
		 
	 } 
 }}
 ?>
 </body>