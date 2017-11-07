<?php
	// Initialize the session
	session_start(); 
?>

<!--	
	Folosesc prepared statements pentru protectie si pentru ca e mai rapid .
	Nu folosesc mysqli_real_escape_string peste tot pentru ca daca un input nu e corect ,
nu vreau sa se continue cu el escape-uit , ci vreau sa nu fie acceptat deloc .
	De accea , la fiecare input se poate face o verificare contextuala ,
de exemplu , cand utilizatorul isi creaza un cont si introduce username-ul , acesta trebuie sa fie de forma : ^[a-zA-Z0-9_]*$ ,
adica contine doar litere nici , mari , cifre si '_' .
 -->

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Acasa </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php include 'external_css_javascript.php' ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>

</style>

</head>


<body>

<!-- Header ////////////////////////////////////// -->
<?php include 'header.php'; ?>

<!-- Slider ////////////////////////////////////// -->
<?php include 'slider.php'; ?>


<div id="main">

<!-- Meniu stanga ////////////////////////////////////// -->
<?php include 'meniu_stanga_si_sus.php'; ?>


<!-- Continut ////////////////////////// -->
	
	<div id="content">	
		<h3 style="margin-left:20px"> Acasa </h3>
		<pre style="font-family: 'Times New Roman', Times, serif;"> 
    SC CaTelNet SRL prin serviciile de televiziune prin cablu, telefonie fixa si internet, oferite, vine in intampinarea nevoilor clientilor astfel 
incat sa fim un partener de incredere in colaborarile viitoare.
    Echipa pe care ne bazam, seriozitatea si relatiile cu partenerii de afaceri, reprezinta garantia ca serviciile sunt de cea mai buna calitate.
    Colaborand cu noi veti avea satisfactie garantata.
    Afacerile care merita facute sunt cele bune, cele foarte bune si cele impreuna cu noi.
		
    Procedura functionala de solutionare a reclamatiilor.
	
    SC CaTelNet SRL pune la dispozitia clientilor urmatoarele modalitati de preluare si solutionare a sesizarilor :
    - telefonic 7/7 zile, 24/24 ore la nr. 0744 310 710
    - la sediul central din str.Revolutiei, nr.1
    - email : catelnet@tvcatelnet.ro
		</pre>
	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>