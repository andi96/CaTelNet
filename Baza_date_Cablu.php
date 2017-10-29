<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php include 'external_css_javascript.php' ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>

</style>

</head>


<body>

<!-- Header ////////////////////////////////////// -->
<?php include 'header.php'; ?>

<div id="main">

<!-- Meniu stanga ////////////////////////////////////// -->
<?php include 'meniu_stanga_si_sus.php'; ?>

	
<!-- Continut ////////////////////////// -->
	
	<div id="content">	
		<p> Baza date cu abonatii de Cablu </p>
			
		<form action="Rezultat_cautare_Cablu.php" method="post">
		ID_abonat: <input type="text" name="ID_abonat"><br>
		<input type="submit">
		</form>

	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>