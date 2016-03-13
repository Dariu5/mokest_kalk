<!doctype html>

<html lang="lt">
<head>
  <meta charset="utf-8">

  <title>Importo mokesčių kalkulaitorius</title>
  <meta name="description" content="Importo mokesčių kalkulaitorius">
  <meta name="author" content="radiocool.lt">

<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>

<?php
$p_verte = $_POST['p_verte'];
$s_verte = $_POST['s_verte'];
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
  <input type="submit" class="button" value="Skaičiuoti"><br>
  
   Viso, eur:<br>
  <input type="text" name="v_verte" value="'.$suma.'"><br>
</form>
';
 ?>