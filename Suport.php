<?php
	// Initialize the session
	session_start(); 
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Suport </title>

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
		
		<pre style="font-family: 'Times New Roman', Times, serif;"> 
Se configureaza conexiunea PPOE cu user name si parola primita de la provider.
	
Telefon: 0355 501 501
Email: catelnet@tvcatelnet.round
		</pre>
		
	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>